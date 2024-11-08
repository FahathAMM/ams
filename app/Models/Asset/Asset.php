<?php

namespace App\Models\Asset;

use App\Helper\Media;
use App\Models\Employee\Employee;
use App\Models\asset\AssetCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;
    use Media;

    protected $fillable = [
        'name',
        'serial_number',
        'category_id',
        'img',
        'tags',
        'issue_date',
        'return_date',
        'condition',
        'warranty_nfo',
        'description',
        'employee_id',
        'is_active',
    ];

    protected $casts = [
        'tags' => 'array',
        'issue_date' => 'datetime:Y-m-d',
    ];


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function getImgAttribute($value)
    {
        $defaultImage = 'https://img.freepik.com/free-vector/isometric-wireless-mobile-devices_98292-171.jpg?t=st=1722096066~exp=1722099666~hmac=311133b16331125bb59c6abcfb14ba79bb8a44fcf85e253a8298f34d9952ecdd&w=740';
        // Check if the value is empty
        if (!$value) {
            return $defaultImage;
        }

        // Check if the file exists in storage
        if (Storage::exists('public/' . $value)) {
            return asset('storage/' . $value);
        } else {
            return $defaultImage;
        }
    }
}
