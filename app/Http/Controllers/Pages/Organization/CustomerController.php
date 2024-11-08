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
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer\Customer;
use App\Models\Department\Department;
use App\Repositories\Organization\CustomerRepo;
use App\Repositories\Organization\EmployeeRepo;

class CustomerController extends Controller
{
    protected $modelName = 'Customer';
    protected $routeName = 'customer.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Customer $model, CustomerRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:organization-employee-view')->only('index');
        // $this->middleware('userpermission:organization-employee-create')->only('create');
        // $this->middleware('userpermission:organization-employee-edit')->only('edit');
    }

    public function index(Request $request)
    {
        // return $this->model->get();

        $layout = $request->input('layout', 'grid');

        // return $employees = $this->model->with(['branch:id,branch_name', 'department:id,department_name'])->get();

        if ($request->ajax()) {

            $permissions = [
                'isDelete' =>  false,
                'isEdit' =>  true,
                'isView' => false,
                'isPrint' => false
            ];

            $model = $this->model->query();

            return Datatables::of($model)->addIndexColumn()
                ->addColumn('action', function ($model) use ($permissions) {
                    return actionBtns(
                        $model->id,
                        'customer.edit',
                        'customer',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.organization.customer.index', [
            'customers' =>   $this->model->get(),
            'roles' =>   Role::get(),
            'title' =>   $this->modelName,
            'layout' =>   $layout,
        ]);
    }

    public function create()
    {
        return view('pages.organization.customer.create', [
            'title' =>   $this->modelName,
            'countries' =>   Country::COUNTRIES,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created =  $this->repo->createCustomer($request);
            if ($created) {
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function edit(Customer $customer)
    {
        try {
            return view('pages.organization.customer.edit', [
                'title' =>   $this->modelName,
                'countries' =>   Country::COUNTRIES,
                'customer' => $customer,
            ]);
        } catch (\Throwable $th) {
            // Handle any errors here if needed
            // Log or return an error response
            // throw $th; // Uncomment this line if you want to throw the exception for debugging
        }
    }

    public function update(UpdateRequest $request, Customer $customer)
    {
        try {
            $created = $this->repo->updateCustomer($request, $customer);
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
