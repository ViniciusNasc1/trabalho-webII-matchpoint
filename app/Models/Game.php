<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class Game extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'platform',
        'image_url',
    ];

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }
}
