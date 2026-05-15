@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Détails de l'agent</h3>
        <a href="{{ route('agents.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Informations personnelles</div>
                <div class="card-body">
                    <p><strong>Nom :</strong> {{ $agent->nom }}</p>
                    <p><strong>Prénom :</strong> {{ $agent->prenom }}</p>
                    <p><strong>Matricule :</strong> {{ $agent->matricule_solde }}</p>
                    <p><strong>Lieu d'affectation :</strong> {{ $agent->lieu_affectation }}</p>
                    <p><strong>Direction :</strong> {{ $agent->direction ?: 'Non défini' }}</p>
                    <p><strong>UFR :</strong> {{ $agent->ufr ?: 'Non défini' }}</p>
                    <p><strong>Date de prise de service :</strong> {{ $agent->date_prise_service->format('d/m/Y') }}</p>
                    <p><strong>Enfants :</strong> {{ $agent->enfants }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Situation des congés</div>
                <div class="card-body">
                    <p><strong>Congés dus :</strong> {{ $agent->jours_conges_dus }}</p>
                    <p><strong>Jours ouvrables à prendre :</strong> {{ $agent->jours_ouvrables_a_prendre }}</p>
                    <p><strong>Absences à déduire :</strong> {{ $agent->absences_a_defalquer }}</p>
                    <p><strong>Jours restants :</strong> {{ $agent->jours_restants }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Historique des absences</div>
                <div class="card-body">
                    @if($agent->absences->isEmpty())
                        <p>Aucune absence enregistrée.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Jours</th>
                                        <th>Déductible</th>
                                        <th>Motif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agent->absences as $absence)
                                        <tr>
                                            <td>{{ $absence->type }}</td>
                                            <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
                                            <td>{{ $absence->date_fin->format('d/m/Y') }}</td>
                                            <td>{{ $absence->nombre_jours }}</td>
                                            <td>{{ $absence->deductible ? 'Oui' : 'Non' }}</td>
                                            <td>{{ $absence->motif }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Historique des congés</div>
                <div class="card-body">
                    @if($agent->leaveRequests->isEmpty())
                        <p>Aucune demande de congé enregistrée.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Départ</th>
                                        <th>Fin</th>
                                        <th>Jours ouvrables</th>
                                        <th>Retour</th>
                                        <th>Déductible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agent->leaveRequests as $leave)
                                        <tr>
                                            <td>{{ $leave->type }}</td>
                                            <td>{{ $leave->date_debut->format('d/m/Y') }}</td>
                                            <td>{{ $leave->date_fin->format('d/m/Y') }}</td>
                                            <td>{{ $leave->jours_ouvrables }}</td>
                                            <td>{{ $leave->date_reprise_service->format('d/m/Y') }}</td>
                                            <td>{{ $leave->deduit ? 'Oui' : 'Non' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
