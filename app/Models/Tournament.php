<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'created_by',
        'name',
        'mode',
        'max_participants',
        'status',
        'starts_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function matches()
    {
        return $this->hasMany(Matchup::class);
    }

    public function participants()
    {
        return $this->hasMany(TournamentParticipant::class);
    }

    public function isSolo(): bool
    {
        return $this->mode === 'solo';
    }

    public function isTeam(): bool
    {
        return $this->mode === 'team';
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    public function isFinished(): bool
    {
        return $this->status === 'finished';
    }

    public function isFull(): bool
    {
        return $this->participants()->count() >= $this->max_participants;
    }
}