<?php

namespace App\Models\Department;

use App\Models\Branch\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    // Specify the table if not following Laravel's convention
    // protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'department_code',
        'description',
        'branch_id',
        'email',
        'phone_number',
        'established_date',
        'is_active',
        'notes',
    ];

    // Define the relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
