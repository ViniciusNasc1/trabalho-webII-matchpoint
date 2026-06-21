<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'name',
        'tag',
        'logo_url',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('status', 'joined_at')
                    ->withTimestamps();
    }

    public function activeMembers()
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