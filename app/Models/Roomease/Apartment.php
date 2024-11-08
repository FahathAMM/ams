<?php

namespace App\Models\Roomease;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'floors',
        'has_parking',
        'description',
    ];

    /**
     * Get the rooms associated with the apartment.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
