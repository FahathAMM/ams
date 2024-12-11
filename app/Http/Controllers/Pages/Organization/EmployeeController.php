<?php

namespace App\Http\Controllers\Pages\Organization;

use App\Models\User;
use App\Constants\Title;
use App\Constants\Country;
use Illuminate\Http\Request;
use App\Models\Branch\Branch;
use App\Models\Leave\LeaveType;
use Yajra\DataTables\DataTables;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
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
        $currentUser = currentUser();
        $permissions = [
            'isDelete' =>  false,
            'isEdit' => can('organization-employee-edit'),
            'isView' => can('organization-employee-view'),
            'isPrint' => false
        ];

        if ($request->ajax()) {

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
                ->rawColumns(['action'])->make(true);
        }

        return view('pages.organization.employee.index', [
            'employees' =>   $this->model->with('department')->get(),
            'title' =>   $this->modelName,
            'layout' =>   $layout,
            'permissions' =>   $permissions,
            'currentUser' =>   $currentUser,
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
        $employee = $this->repo->findEmployeeById($id);
        $empEodLogs = $this->repo->assignedEmployeeEodLogs($employee);

        // return $employee;
        // return $employee->getFilteredLeaveBalance();

        return view('pages.organization.asset.show', [
            'employee' => $employee,
            'empEodLogs' => $empEodLogs,
            'title' =>   $this->modelName,
        ]);
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::get();
        $departments = Department::get();

        // $employee->leave_types;

        try {
            return view('pages.organization.employee.edit', [
                'countries' =>   Country::COUNTRIES,
                'title' =>   Title::TITLE,
                'titleName' =>   $this->modelName,
                'branches' => $branches,
                'departments' => $departments,
                'leaveTypes' =>   LeaveType::get(),
                'employee' => $employee,
                'employees' => Employee::with('reportManager:id,first_name,last_name,username')->get(['id', 'first_name', 'last_name']),
            ]);
        } catch (\Throwable $th) {
            throw $th;
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
