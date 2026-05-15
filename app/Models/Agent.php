<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'matricule_solde',
        'lieu_affectation',
        'direction',
        'ufr',
        'date_prise_service',
        'date_cessation_service',
        'date_reprise_service',
        'jours_conges_dus',
        'jours_ouvrables_a_prendre',
        'absences_a_defalquer',
        'jours_restants',
        'enfants',
    ];

    protected $casts = [
        'date_prise_service' => 'date',
        'date_cessation_service' => 'date',
        'date_reprise_service' => 'date',
    ];

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function calculateRestants(): int
    {
        return max(0, $this->jours_conges_dus - $this->jours_ouvrables_a_prendre);
    }

    public function calculateCongesDus(): int
    {
        $datePriseService = $this->date_prise_service;
        $now = now();
        $yearsOfService = $datePriseService->diffInYears($now);

        // Après 12 mois, 24 jours par an
        $totalDus = max(0, $yearsOfService * 24);

        // Ajouter les jours pour enfants
        $totalDus += $this->enfants;

        // Soustraire les absences déductibles
        $totalDus -= $this->absences_a_defalquer;

        return max(0, $totalDus);
    }
}
