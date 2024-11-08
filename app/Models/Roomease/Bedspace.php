<?php

namespace App\Models\Roomease;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bedspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'bedspace_number',
        'bed_type',
        'rate',
        'is_occupied',
        'description',
    ];

    /**
     * Get the room that owns the bedspace.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
