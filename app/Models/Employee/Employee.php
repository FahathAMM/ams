<?php

namespace App\Models\Employee;

use App\Helper\Media;
use App\Models\Asset\Asset;
use App\Models\Branch\Branch;
use App\Models\Department\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use Media;

    protected $fillable = [
        'first_name',
        'last_name',
        'emp_number',
        'designation',
        'phone_number',
        'username',
        'password',
        'email',
        'is_active',
        'branch_id',
        'department_id',
        'joining_date',
        'country',
        'description',
        'gender',
        'img',
        'cover_img',
        // Add any additional fields you need
    ];

    protected $appends = [
        'full_name',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function reportManager() // this relation for creating
    {
        return $this->belongsToMany(Employee::class, 'employee_report', 'employee_id', 'report_manager_id');
    }

    public function reportingManager() // this relation for getting
    {
        return $this->belongsToMany(Employee::class, 'employee_report', 'report_manager_id', 'employee_id');
        // return $this->belongsToMany(Employee::class, 'employee_report', 'employee_id', 'report_manager_id');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    // public function setJoiningDateAttribute($value)
    // {
    //     // Parse the input date and set the attribute
    //     $this->attributes['joining_date'] = Carbon::createFromFormat('d M, Y', $value)->format('Y-m-d');
    // }

    public function getImgAttribute($value)
    {
        // $defaultImage = 'https://hancockogundiyapartners.com/wp-content/uploads/2019/07/dummy-profile-pic-300x300.jpg';
        $defaultImage = asset('storage/demo/dm-profile.jpg');
        if (!$value) {
            return $defaultImage;
        }

        if (Storage::exists('public/' . $value)) {
            return asset('storage/' . $value);
        } else {
            return $defaultImage;
        }
    }

    public function getCoverImgAttribute($value)
    {
        // $defaultImage = 'https://hancockogundiyapartners.com/wp-content/uploads/2019/07/dummy-profile-pic-300x300.jpg';
        $defaultImage = asset('storage/demo/dm-cover.jpg');

        if (!$value) {
            return $defaultImage;
        }

        if (Storage::exists('public/' . $value)) {
            return asset('storage/' . $value);
        } else {
            return $defaultImage;
        }
    }
}
