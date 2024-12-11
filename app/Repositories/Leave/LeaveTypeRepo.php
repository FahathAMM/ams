<?php

namespace App\Repositories\Leave;

use App\Models\Leave\LeaveType;
use App\Repositories\BaseRepository;

class LeaveTypeRepo extends BaseRepository
{
    protected $model;

    public function __construct(LeaveType $model)
    {
        $this->model = $model;
    }

    public function createLeaveType($request)
    {
        try {
            $created = $this->model->create($request->validated());

            if ($created) {
                return $created;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateLeaveType($request, $leaveType)
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
