<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_header_id',
        'name1',
        'name2',
        'sequence',
        'page_url',
        'is_submenu_available',
        'is_active',
        'icon'
    ];

    public function menuHeader()
    {
        return $this->belongsTo(MenuHeader::class);
    }

    public function menuSubDetails()
    {
        return $this->hasMany(MenuSubDetail::class);
    }
}
