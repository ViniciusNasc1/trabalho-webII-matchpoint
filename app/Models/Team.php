<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'tag',
        'logo_url',
    ];

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('status', 'joined_at')
                    ->withTimestamps();
    }

    public function activeMembers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('status', 'joined_at')
                    ->wherePivot('status', 'active')
                    ->withTimestamps();
    }

    public function tournaments(){
        return $this->morphToMany(Tournament::class, 'participant', 'tournament_participants');
    }
}