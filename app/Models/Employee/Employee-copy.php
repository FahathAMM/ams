<?php

namespace App\Models\Employee;

use App\Helper\Media;
use App\Constants\Country;
use App\Models\Asset\Asset;
use App\Models\Branch\Branch;
use App\Models\Department\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee1 extends Model
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

    public function formFields()
    {
        $branches = [
            ['name' => 'Dubai', 'value' => 'Dubai'],
            ['name' => 'Saudi Arabia', 'value' => 'Saudi Arabia'],
            ['name' => 'Oman', 'value' => 'Oman'],
            ['name' => 'Qatar', 'value' => 'Qatar'],
            ['name' => 'India', 'value' => 'India'],
        ];

        $departments = [
            ['name' => 'Management', 'value' => 'Management'],
            ['name' => 'Development', 'value' => 'Development'],
            ['name' => 'Sales', 'value' => 'Sales'],
            ['name' => 'Finance', 'value' => 'Finance'],
            ['name' => 'Administration', 'value' => 'Administration'],
            ['name' => 'IT Infrastructure', 'value' => 'IT Infrastructure'],
            ['name' => 'Hardware', 'value' => 'Hardware'],
        ];


        return [
            [
                'type' => 'text',
                'label' => 'First Name',
                'name' => 'first_name',
                'placeholder' => 'Enter your first name',
                'col' => 6,
            ],
            [
                'type' => 'text',
                'label' => 'Last Name',
                'name' => 'last_name',
                'placeholder' => 'Enter your last name',
                'col' => 6,
            ],
            [
                'type' => 'number',
                'label' => 'Employee ID',
                'name' => 'employee_id',
                'placeholder' => 'Enter employee ID',
                'col' => 6,
            ],
            [
                'type' => 'text',
                'label' => 'Designation',
                'name' => 'designation',
                'placeholder' => 'Enter your designation',
                'col' => 6,
            ],
            [
                'type' => 'text',
                'label' => 'Phone Number',
                'name' => 'phone_number',
                'placeholder' => 'Enter your phone number',
                'col' => 6,
            ],
            [
                'type' => 'email',
                'label' => 'Email Address',
                'name' => 'email',
                'placeholder' => 'Enter your email',
                'col' => 6,
            ],
            [
                'type' => 'select',
                'label' => 'Branch',
                'name' => 'branch',
                'items' => $branches,
                'itemText' => 'name',
                'itemValue' => 'value',
                'col' => 6,
            ],
            [
                'type' => 'select',
                'label' => 'Department',
                'name' => 'department',
                'items' => $departments,
                'itemText' => 'name',
                'itemValue' => 'value',
                'col' => 6,
            ],
            [
                'type' => 'date',
                'label' => 'Joining Date',
                'name' => 'joining_date',
                'placeholder' => 'Select date',
                'col' => 6,
            ],
            [
                'type' => 'select',
                'label' => 'Country',
                'name' => 'country',
                'items' => Country::COUNTRIES,
                'itemText' => 'name',
                'itemValue' => 'value',
                'col' => 6,
            ],
            [
                'type' => 'select',
                'label' => 'Gender',
                'name' => 'gender',
                'items' => Country::COUNTRIES,
                'itemText' => 'name',
                'itemValue' => 'value',
                'col' => 6,
            ],
            [
                'type' => 'select',
                'label' => 'Status',
                'name' => 'status',
                'items' => Country::COUNTRIES,
                'itemText' => 'name',
                'itemValue' => 'value',
                'col' => 6,
            ],
            [
                'type' => 'textarea',
                'label' => 'Description',
                'name' => 'description',
                'placeholder' => 'Enter your description',
                'col' => 12,
            ],
        ];
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
