<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tournament_participants';

    protected $fillable = [
        'tournament_id',
        'participant_type',
        'participant_id',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
        ];
    }

    public function tournament(){
        return $this->belongsTo(Tournament::class);
    }

    public function participant(){
        return $this->morphTo();
    }
}