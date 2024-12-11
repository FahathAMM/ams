<?php

namespace App\Models\Leave;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    // Specify the fields that are mass assignable
    protected $fillable = [
        'leave_type_id',
        'start_date',
        'end_date',
        'body',
        'applied_employee_id',
        'request_days',
    ];

    public function leaveReportingManagers()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function appliedEmployee()
    {
        return $this->belongsTo(Employee::class, 'applied_employee_id');
    }

    public function employees()
    {
        // return $this->belongsToMany(Employee::class)
        return $this->belongsToMany(Employee::class, 'employee_leave_request', 'leave_request_id', 'employee_id')
            // ->withPivot(['status', 'rejected_reason', 'approved_reason'])
        ;
    }
}
