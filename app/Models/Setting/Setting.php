<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'key',
        'value',
        'type',
        'user_id',
        'level',
        'is_active',
        'is_visible',
    ];

    // Optionally, if you want to cast certain attributes
    protected $casts = [
        'user_id' => 'integer',
        'level' => 'string',
    ];

    protected $appends = [
        'key_name'
    ];

    public function getKeyNameAttribute($value)
    {
        return ucwords(str_replace('_', ' ', $this->attributes['key']));
        // return ucfirst(str_replace('_', ' ', $this->attributes['key']));
    }
}
