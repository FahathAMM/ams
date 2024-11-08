<?php

namespace App\Http\Controllers\Pages\Organization;

use App\Models\User;
use App\Constants\Title;
use App\Constants\Country;
use Illuminate\Http\Request;
use App\Models\Branch\Branch;
use Yajra\DataTables\DataTables;
use App\Models\Employee\Employee;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Models\Department\Department;
use App\Repositories\Organization\EmployeeRepo;

class EmployeeController extends Controller
{
    protected $modelName = 'Employee';
    protected $routeName = 'employee.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Employee $model, EmployeeRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:organization-employee-view')->only('index');
        $this->middleware('userpermission:organization-employee-create')->only('create');
        $this->middleware('userpermission:organization-employee-edit')->only('edit');
    }

    public function index(Request $request)
    {
        $layout = $request->input('layout', 'grid');


        if ($request->ajax()) {

            $permissions = [
                'isDelete' =>  false,
                'isEdit' => can('administration-users-edit'),
                'isView' => can('administration-users-view'),
                'isPrint' => false
            ];

            $employees = $this->model->with(['branch:id,branch_name', 'department:id,department_name']);

            return Datatables::of($employees)->addIndexColumn()
                ->addColumn('action', function ($employees) use ($permissions) {
                    return actionBtns(
                        $employees->id,
                        'employee.edit',
                        'organization/employee',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.organization.employee.index', [
            'employees' =>   $this->model->get(),
            'roles' =>   Role::get(),
            'title' =>   $this->modelName,
            'layout' =>   $layout,
            'userWithRoles' => User::with('roles')->get(),
        ]);
    }

    public function create()
    {
        $branches = Branch::get();
        $departments = Department::get();
        return view('pages.organization.employee.create', [
            'roles' =>   Role::get(),
            'userWithRoles' => User::with('roles')->get(),
            'countries' =>   Country::COUNTRIES,
            'title' =>   Title::TITLE,
            'titleName' =>   $this->modelName,
            'branches' => $branches,
            'departments' => $departments,
            'employees' => Employee::with('reportManager')->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function createFormDataMethod()
    {
        return view('pages.organization.employee.create', [
            'roles' =>   Role::get(),
            'userWithRoles' => User::with('roles')->get(),
            'countries' =>   Country::COUNTRIES,
            'title' =>   Title::TITLE,
            'formFields' => $this->model->formFields(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createEmployee($request);
            if ($created) {
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function show(string $id)
    {
        // return $this->repo->findEmployeeById($id);

        return view('pages.organization.asset.show', [
            'employee' => $this->repo->findEmployeeById($id),
            'title' =>   $this->modelName,
        ]);
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::get();
        $departments = Department::get();
        try {
            return view('pages.organization.employee.edit', [
                'roles' =>   Role::get(),
                'userWithRoles' => User::with('roles')->get(),
                'countries' =>   Country::COUNTRIES,
                'title' =>   Title::TITLE,
                'titleName' =>   $this->modelName,
                'branches' => $branches,
                'departments' => $departments,
                'employee' => $employee,
                'employees' => Employee::with('reportManager:id,first_name,last_name,username')->get(['id', 'first_name', 'last_name']),
            ]);
        } catch (\Throwable $th) {
            // Handle any errors here if needed
            // Log or return an error response
            // throw $th; // Uncomment this line if you want to throw the exception for debugging
        }
    }

    public function update(UpdateRequest $request, Employee $employee)
    {
        try {
            $created = $this->repo->updateEmployee($request, $employee);
            if ($created) {
                return  $this->response($this->modelName . ' Update successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
