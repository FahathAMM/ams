<?php

namespace App\Models\Customer;

use App\Models\Branch\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'website',
        'business_type',
        'industry',
        'contact_person_name',
        'contact_email',
        'contact_phone',
        'customer_since',
        'is_active',
        'description',
        'account_manager_id'
    ];
}
