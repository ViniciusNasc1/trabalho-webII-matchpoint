<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class TournamentParticipant extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory, SoftDeletes;

    protected $table = 'tournaments_participants';

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
