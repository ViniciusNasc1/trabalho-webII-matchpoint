<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'platform',
        'image_url',
    ];

    public function tournaments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tournament::class);
    }
}