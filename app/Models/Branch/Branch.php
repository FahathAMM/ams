<?php

namespace App\Models\Branch;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'branch_name',
        'branch_code',
        'location_address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone_number',
        'email',
        'opening_date',
        'is_active',
        'notes'
    ];
}
