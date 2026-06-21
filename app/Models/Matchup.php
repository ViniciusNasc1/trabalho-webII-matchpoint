<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matchup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'round_number',
        'round_label',
        'participant_a_type',
        'participant_a_id',
        'participant_b_type',
        'participant_b_id',
        'winner_type',
        'winner_id',
        'status',
        'scheduled_at',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participantA()
    {
        return $this->morphTo('participant_a');
    }

    public function participantB()
    {
        return $this->morphTo('participant_b');
    }

    public function winner()
    {
        return $this->morphTo('winner');
    }

    public function result(){
        return $this->hasOne(Result::class, 'match_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFinished(): bool
    {
        return $this->status === 'finished';
    }

    public function hasWinner(): bool
    {
        return !is_null($this->winner_id);
    }
}