<?php

namespace App\Http\Controllers\Pages\WorkBase;

use App\Models\User;
use App\Models\Task\Task;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\WorkBase\TaskRepo;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;

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
            'title' =>   $this->modelName,
            'schedules' =>   $task,
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

    public function EODAssign(Request $request)
    {
        $employees = Employee::get();

        return view('pages.workBase.eod.eod-assign', [
            'title' =>   'Assign EOD Reporting Manager',
            'employees' =>   $employees,
        ]);
    }

    public function assignedEODStore(Request $request)
    {
        try {
            $employee = Employee::find($request->reporting_manager_id);
            $employee->reportingManager()->wherePivot('report_type', 'eod_report')->detach();
            $updated = $employee->reportingManager()->attach($request->selectedEodEmployeessArr, ['report_type' => 'eod_report']);

            return  $this->response($this->modelName . ' updated successfully', ['data' => $updated], true);
        } catch (\Throwable $th) {
            // throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function getEmployeesAssignByEmployee(Request $request)
    {
        try {
            $notAssignedEmployees = Employee::whereNotIn('id', function ($query) {
                $query->select('employee_id')
                    ->from('employee_report');
            })->get(['id as value', 'username as text', DB::raw('false as selected')]);

            $assignedEmployeesByReportManager = Employee::whereIn('id', function ($query) use ($request) {
                $query->select('employee_id')->where('report_manager_id', $request->reporting_manager_id)
                    ->from('employee_report');
            })->get(['id as value', 'username as text', DB::raw('true as selected')]);

            $eodEmployee = [
                ...$notAssignedEmployees,
                ...$assignedEmployeesByReportManager,
            ];

            return  $this->response($this->modelName . '', ['eodEmployee' => $eodEmployee], true);
        } catch (\Throwable $th) {
            throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
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
