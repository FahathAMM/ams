<?php

namespace App\Http\Controllers\Pages\Leave;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Leave\LeaveRequestRepo;
use App\Http\Requests\Leaverequest\StoreRequest;

class LeaveController extends Controller
{
    protected $modelName = 'Leave Requst';
    protected $routeName = 'leave.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(LeaveRequest $model, LeaveRequestRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:organization-employee-view')->only('index');
    }

    public function index(Request $request)
    {
        return view('pages.leave.leaverequest.index', [
            'employees' =>   $this->model->get(),
            'title' =>   $this->modelName,
            'schedules' =>   [],
        ]);
    }

    public function LeaveRequestList(Request $request)
    {
        $LeaveRequestListByReportingManager = LeaveRequest::with([
            'leaveType',
            // 'employees',
            // 'appliedEmployee' => ['branch', 'department'],
            'appliedEmployee:id,first_name,last_name,img',
        ])
            ->select([
                'elr.employee_id as reporting_manager',
                'leave_requests.body',
                'leave_requests.request_days',
                'leave_requests.start_date',
                'leave_requests.end_date',
                'leave_requests.applied_employee_id',
                'leave_requests.leave_type_id',
                'lb.remaining_days',
                'lb.*',
                'elr.id as elrid',
                'elr.employee_id as empId',
                'elr.status',
                'elr.rejected_reason',
                'elr.approved_reason'
            ])

            // ->whereHas('employees', function ($query) {
            //     $query->where('employee_id', CurrentUser()->employee_id);
            // })

            ->where('elr.employee_id', CurrentUser()->employee_id)
            ->join('leave_balances as lb', function ($join) {
                $join->on('lb.leave_type_id', '=', 'leave_requests.leave_type_id')
                    ->on('lb.employee_id', '=', 'leave_requests.applied_employee_id');
            })
            ->join('employee_leave_request as elr', 'elr.leave_request_id', '=', 'leave_requests.id')
            ->paginate(9);

        // return $LeaveRequestListByReportingManager;
        return view('pages.leave.leaverequest.list', [
            'employees' =>   $this->model->get(),
            'title' =>   $this->modelName,
            'LeaveRequestListByReportingManager' => $LeaveRequestListByReportingManager,
        ]);
    }

    public function responseAppliedLeaveByReportingManager(Request $request)
    {
        // Validate input
        $request->validate([
            'leave_request_id' => 'required|exists:leave_requests,id',
            'reporting_manager_id' => 'required|exists:employees,id',
            'status' => 'required|in:Approved,Rejected,Pending',
            'reason' => 'nullable|string|max:255',
        ]);

        try {
            // Delegate logic to the repository
            $result = $this->repo->processLeaveResponse($request);

            if ($result['success']) {
                return $this->response($result['message'], ['data' => $result['data']], true);
            } else {
                return $this->response($result['message'], ['data' => null], false);
            }
        } catch (\Throwable $th) {
            // Log the error and return a response
            Log::error($th->getMessage());
            return $this->response('An error occurred while processing the leave request.', null, false);
        }
    }

    public function create(Request $request)
    {
        $currentEmployee = currentEmployee();

        return view('pages.leave.leaverequest.create', [
            'title' =>   $this->modelName,
            'date' =>   $request->date,
            'leaveReportEmployees' => Employee::whereNot('id', $currentEmployee->id)->get(),
            'selectLeaveDays' => $this->calculateLeaveDays($request->start, $request->end),
            'data' => $request->only(['start', 'end']),
            'currentEmployeeId' => $currentEmployee->id,
            'leaveTypes' => $currentEmployee->getFilteredLeaveByEmployee(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createLeaveRequest($request);

            if ($created) {
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
    }

    private function calculateLeaveDays($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            // If start date is after the end date, return 0 or throw an exception as needed.
            if ($start->greaterThan($end)) {
                return 0;  // or throw an exception if appropriate
            }

            // Return the difference in days including the start day
            return $start->diffInDays($end) + 1; // Adding 1 to include the start date
        } else {
            return 1;  // Return 1 day if no dates are provided
        }
    }
}
