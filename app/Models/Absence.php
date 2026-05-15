<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'type',
        'date_debut',
        'date_fin',
        'nombre_jours',
        'deductible',
        'motif',
        'created_by',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'deductible' => 'boolean',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
