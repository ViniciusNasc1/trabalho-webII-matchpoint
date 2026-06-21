<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'match_id',
        'registered_by',
        'score_a',
        'score_b',
        'notes',
    ];

    public function match(){
        return $this->belongsTo(Matchup::class, 'match_id');
    }

    public function registeredBy(){
        return $this->belongsTo(User::class, 'registered_by');
    }
}