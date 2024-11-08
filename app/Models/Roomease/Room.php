<?php

namespace App\Models\Roomease;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'room_number',
        'floor',
        'type',
        'is_occupied',
        'description',
    ];

    /**
     * Get the apartment that owns the room.
     */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * Get the bedspaces associated with the room.
     */
    public function bedspaces()
    {
        return $this->hasMany(Bedspace::class);
    }
}
