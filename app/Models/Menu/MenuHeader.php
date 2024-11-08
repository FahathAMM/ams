<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name1',
        'name2',
        'is_active',
        'icon',
        'menu_code',
        'menu'
    ];

    protected $casts = [
        'menu' => 'array',
    ];

    public function menuDetails()
    {
        return $this->hasMany(MenuDetail::class);
    }
}
