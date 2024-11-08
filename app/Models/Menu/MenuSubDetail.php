<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSubDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_detail_id',
        'name1',
        'name2',
        'sequence',
        'page_url',
        'is_active',
        'icon'
    ];

    public function menuDetail()
    {
        return $this->belongsTo(MenuDetail::class);
    }
}
