@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h1 class="h2 fw-700" style="color: #2c3e50;">
                        <i class="bi bi-speedometer2" style="color: #667eea;"></i> Tableau de bord
                    </h1>
                    <p class="text-muted mb-0">Bienvenue dans la plateforme de gestion des absences et congés</p>
                </div>
                <div class="col-auto">
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 15px; font-size: 0.9rem;">
                        <i class="bi bi-calendar-event"></i> {{ now()->format('d/m/Y') }}
                    </span>
                </div>
            </div>

            <!-- Cartes de statistiques -->
            <div class="row g-4 mb-5">
                <!-- Agents -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 text-white-50">Agents</p>
                                    <h3 class="mb-0" style="font-weight: 700; font-size: 2.5rem;">{{ $agentsCount }}</h3>
                                </div>
                                <i class="bi bi-people-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <a href="{{ route('agents.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-arrow-right"></i> Gérer
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Absences -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 text-white-50">Absences</p>
                                    <h3 class="mb-0" style="font-weight: 700; font-size: 2.5rem;">{{ $absencesCount }}</h3>
                                </div>
                                <i class="bi bi-x-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <a href="{{ route('absences.index') }}" class="btn btn-sm btn-outline-danger w-100">
                                <i class="bi bi-arrow-right"></i> Consulter
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Congés -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 text-white-50">Congés</p>
                                    <h3 class="mb-0" style="font-weight: 700; font-size: 2.5rem;">{{ $leavesCount }}</h3>
                                </div>
                                <i class="bi bi-calendar2-check-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <a href="{{ route('leaves.index') }}" class="btn btn-sm btn-outline-info w-100">
                                <i class="bi bi-arrow-right"></i> Demandes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total congés dus -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 20px; color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 text-white-50">Congés dus</p>
                                    <h3 class="mb-0" style="font-weight: 700; font-size: 2.5rem;">{{ $latestAgents->sum('jours_conges_dus') }}</h3>
                                </div>
                                <i class="bi bi-graph-up-arrow" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <span class="badge bg-success">Jours totaux</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3" style="font-weight: 700;">Actions rapides</h5>
                            <div class="row g-2">
                                <div class="col-auto">
                                    <a href="{{ route('agents.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        <i class="bi bi-plus-circle"></i> Ajouter un agent
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('absences.create') }}" class="btn" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                        <i class="bi bi-plus-circle"></i> Nouvelle absence
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('leaves.create') }}" class="btn" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                        <i class="bi bi-plus-circle"></i> Demande de congé
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('reports.index') }}" class="btn" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                                        <i class="bi bi-file-pdf"></i> Voir les rapports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers agents -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header bg-light border-0" style="border-radius: 12px 12px 0 0; padding: 1.5rem;">
                            <h5 class="mb-0" style="font-weight: 700;">
                                <i class="bi bi-clock-history" style="color: #667eea;"></i> Derniers agents enregistrés
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($latestAgents->isEmpty())
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Aucun agent enregistré pour l'instant</p>
                                    <a href="{{ route('agents.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-circle"></i> Ajouter le premier agent
                                    </a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="bi bi-person"></i> Nom</th>
                                                <th><i class="bi bi-card-text"></i> Matricule</th>
                                                <th><i class="bi bi-geo-alt"></i> Lieu</th>
                                                <th class="text-end"><i class="bi bi-calendar-check"></i> Jours dus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($latestAgents->take(10) as $agent)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $agent->prenom }} {{ $agent->nom }}</strong>
                                                    </td>
                                                    <td>
                                                        <code style="background: #f0f0f0; padding: 2px 6px; border-radius: 4px;">{{ $agent->matricule_solde }}</code>
                                                    </td>
                                                    <td>{{ $agent->lieu_affectation }}</td>
                                                    <td class="text-end">
                                                        <span class="badge" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                                            {{ $agent->jours_conges_dus }} jours
                                                        </span>
                                                    </td>
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
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
