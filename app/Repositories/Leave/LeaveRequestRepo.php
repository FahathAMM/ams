<?php

namespace App\Repositories\Leave;

use App\Models\Leave\LeaveRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;

class LeaveRequestRepo extends BaseRepository
{
    protected $model;

    public function __construct(LeaveRequest $model)
    {
        $this->model = $model;
    }

    public function createLeaveRequest($request)
    {
        try {
            $created = $this->model->create($request->validated());

            if ($created) {
                $created->leaveReportingManagers()->attach($request->employee_id, ['created_at' => now(), 'updated_at' => now()]);
                return $created;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function processLeaveResponse1($request)
    {
        try {
            $status = $request->status;
            $reasonCol = $status === 'Approved' ? 'approved_reason' : 'rejected_reason';

            // Use a single query to retrieve necessary data, including the leave request and current status
            $leaveRequest = LeaveRequest::with([
                'leaveReportingManagers' => function ($query) use ($request) {
                    $query->where('employee_id', $request->reporting_manager_id)
                        ->select('id', 'leave_request_id', 'employee_id', 'status');
                }
            ])->find($request->leave_request_id);

            if (!$leaveRequest) {
                return $this->response(false, 'Leave request not found.');
            }

            $reportingManager = $leaveRequest->leaveReportingManagers->first();
            if (!$reportingManager) {
                return $this->response(false, 'Reporting manager not found.');
            }

            if ($reportingManager->status === $status) {
                return $this->response(false, 'The leave request has already been processed with the same status.');
            }

            // Use a transaction to ensure atomic updates
            DB::transaction(function () use ($leaveRequest, $reportingManager, $status, $reasonCol, $request) {
                // Update the leave status in the pivot table
                DB::table('leave_reporting_manager')
                    ->where('id', $reportingManager->id)
                    ->update([
                        'status' => $status,
                        $reasonCol => $request->reason,
                        'updated_at' => now(),
                    ]);

                if ($status === 'Approved') {
                    // Decrement leave balance if approved
                    DB::table('leave_balances')
                        ->where('employee_id', $leaveRequest->applied_employee_id)
                        ->where('leave_type_id', $leaveRequest->leave_type_id)
                        ->decrement('remaining_days', (int)$request->number_of_days);
                }
            });

            return $this->response(true, 'Leave request processed successfully.', $leaveRequest);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->response(false, 'An error occurred.');
        }
    }


    public function processLeaveResponse($request)
    {
        try {
            $status = $request->status;
            $reasonCol = $status === 'Approved' ? 'approved_reason' : 'rejected_reason';

            // Find the leave request
            $leaveRequest = LeaveRequest::find($request->leave_request_id);

            if (!$leaveRequest) {
                return ['success' => false, 'message' => 'Leave request not found.'];
            }

            // Check if the status has already been updated to prevent duplicate actions
            $currentStatus = $leaveRequest->leaveReportingManagers()
                ->where('employee_id', $request->reporting_manager_id)
                ->value('status');

            if ($currentStatus === $status) {
                return ['success' => false, 'message' => 'The leave request has already been processed with the same status.'];
            }

            // Update the pivot table or related model
            $update = $leaveRequest->leaveReportingManagers()
                ->where('employee_id', $request->reporting_manager_id)
                ->update([
                    'status' => $status,
                    $reasonCol => $request->reason,
                    'updated_at' => now()
                ]);

            if ($update) {
                if ($status === 'Approved') {
                    // Decrement leave balance if approved and not already processed
                    DB::table('leave_balances')
                        ->where('employee_id', $leaveRequest->applied_employee_id)
                        ->where('leave_type_id', $leaveRequest->leave_type_id)
                        ->decrement('remaining_days', (int)$request->number_of_days);
                }

                return ['success' => true, 'message' => 'Leave request processed successfully.', 'data' => $leaveRequest];
            }

            return ['success' => false, 'message' => 'Failed to update leave request.'];
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ['success' => false, 'message' => 'An error occurred.', 'data' => null];
        }
    }

    private function response(bool $success, string $message, $data = null)
    {
        return compact('success', 'message', 'data');
    }

    public function updateLeaveRequest($request, $leaveType)
    {
        try {
            $updated = $leaveType->update($request->validated());

            if ($updated) {
                return $updated;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
