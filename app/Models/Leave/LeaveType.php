<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number_of_days',
        'description'
    ];

    // Define relationships (if needed)
    // public function leaveRequests()
    // {
    //     return $this->hasMany(LeaveRequest::class);
    // }

    // public function leaveBalances()
    // {
    //     return $this->hasMany(LeaveBalance::class);
    // }
}
