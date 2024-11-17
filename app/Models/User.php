<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Employee\Employee;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'username',
        'password',
        'email',
        'designation',
        'email_verified_at',
        'contact',
        'branch',
        'img',
        'joining_date',
        'is_active',
        'description',
        'role_id',
        'employee_id',
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function setJoiningDateAttribute($value)
    {
        if ($value) {
            $this->attributes['joining_date'] = convertToSqlDateFormat($value);
        }
    }

    public function getImgAttribute($value)
    {
        // Define the default image URL
        $defaultImage = 'https://hancockogundiyapartners.com/wp-content/uploads/2019/07/dummy-profile-pic-300x300.jpg';

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

    public function setPasswordAttribute($value)
    {
        // Hash the password before saving
        $this->attributes['password'] = $this->customEncrypt($value);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    private function customEncrypt($pass)
    {
        $str = $pass;
        $key = '4QcTlzuaNUcX289Z9D0ovPCzb';
        $iv = "1234567812345678";
        $encryption_key = base64_encode($key);
        $encrypted = openssl_encrypt($str, 'aes-256-cbc', $encryption_key, true, $iv);
        $encrypted_data = base64_encode($encrypted);
        return ($encrypted_data);
    }
}
