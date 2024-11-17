<?php

namespace App\Http\Controllers\Pages\WorkBase;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UpdateRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Customer\Customer;
use App\Models\Task\Task;
use App\Repositories\WorkBase\TaskRepo;

class EODController extends Controller
{
    protected $modelName = 'EOD Report';
    protected $routeName = 'eodreport.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Task $model, TaskRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:organization-employee-view')->only('index');
    }

    public function index(Request $request)
    {
        $empId = fetchCurrentEmployeeWithReportingManagers()->id;
        $task = Task::where('employee_id', $empId)->groupBy('eod_date')->get(['id', 'eod_date as start', 'subject as title']);

        return view('pages.workbase.eod.index', [
            'employees' =>   $this->model->get(),
            'roles' =>   Role::get(),
            'title' =>   $this->modelName,
            'schedules' =>   $task,
            'userWithRoles' => User::with('roles')->get(),
        ]);
    }

    public function EODList(Request $request, $id = "")
    {
        $empId = "";

        if ($id) {
            $empId = $id;
        } else {
            $empId = fetchCurrentEmployeeWithReportingManagers()->id;
        }

        return view('pages.workbase.eod.list', [
            'title' =>   $this->modelName,
            'empId' =>   $empId,
        ]);
    }

    public function create(Request $request)
    {
        // return fetchCurrentEmployeeWithReportingManagers()->reportManager[0]->full_name;
        return view('pages.workbase.eod.create', [
            'customers' => Customer::get(['id', 'customer_code', 'first_name', 'last_name', 'company_name']),
            'title' =>   $this->modelName,
            'date' =>   $request->date,
            'repotingManagers' => fetchCurrentEmployeeWithReportingManagers(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {

            $created = $this->repo->createTask($request);
            if ($created) {
                logActivity('EOD Create', "EOD Subject " . $request->subject, 'Create', '', 'eod');
                return $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
            return $this->response('please fill task', ['data' => $created], false);
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function show(string $id)
    {
        return view('pages.organization.asset.show', [
            'employee' => $this->repo->findEmployeeById($id),
            'title' =>   $this->modelName,
        ]);
    }

    public function edit(Employee $employee) {}

    public function update(UpdateRequest $request, Employee $employee) {}

    public function destroy(string $id) {}
}
