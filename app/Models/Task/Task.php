<?php

namespace App\Models\Task;

use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'report_manager_id',
        'customer_id',
        'eod_date',
        'subject',
        'task_code',
        'task_description',
        'duration',
        'description',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function currentEmployeeReportingManagers()
    {
        return $this->belongsTo(Employee::class, 'report_manager_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
