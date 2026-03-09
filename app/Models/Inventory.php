<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'block_inventory')->withPivot('quantity');
    }
}
