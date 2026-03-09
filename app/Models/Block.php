<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'block_name',
        'variant',
        'avg_color_srgb',
        'avg_color_linear',
        'category',
        'family',
        'material',
        'is_transparent',
        'is_solid',
        'detail_form',
        'detail_flammable',
        'detail_interactive',
    ];

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'block_inventory')->withPivot('quantity');
    }
}
