@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row align-items-center mb-5">
        <div class="col">
            <h1 class="h2 fw-700" style="color: #2c3e50;">
                <i class="bi bi-people-fill" style="color: #667eea;"></i> Gestion des Agents
            </h1>
            <p class="text-muted mb-0">Gérez les agents du personnel et leur droits aux congés</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('agents.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Ajouter un agent
            </a>
        </div>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($agents->isEmpty())
        <!-- État vide -->
        <div class="text-center py-5">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 2rem; margin-bottom: 20px;">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="mt-3 fw-600">Aucun agent trouvé</h4>
            <p class="text-muted mb-4">Commencez par ajouter un agent au système</p>
            <a href="{{ route('agents.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Créer le premier agent
            </a>
        </div>
    @else
        <!-- Tableau responsive avec cartes pour mobile -->
        <div class="d-none d-lg-block">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light" style="border-top: none;">
                            <tr>
                                <th><i class="bi bi-person"></i> Nom</th>
                                <th><i class="bi bi-card-text"></i> Matricule</th>
                                <th><i class="bi bi-geo-alt"></i> Lieu</th>
                                <th><i class="bi bi-calendar-check"></i> Dus</th>
                                <th><i class="bi bi-hourglass"></i> À prendre</th>
                                <th><i class="bi bi-x-circle"></i> Absences</th>
                                <th><i class="bi bi-graph-up"></i> Restants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                                <tr>
                                    <td>
                                        <strong>{{ $agent->prenom }} {{ $agent->nom }}</strong>
                                    </td>
                                    <td>
                                        <code style="background: #f0f0f0; padding: 2px 6px; border-radius: 4px;">{{ $agent->matricule_solde }}</code>
                                    </td>
                                    <td>{{ $agent->lieu_affectation }}</td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            {{ $agent->jours_conges_dus }} j
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $agent->jours_ouvrables_a_prendre }} j</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ $agent->absences_a_defalquer }} j</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $agent->jours_restants }} j</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('agents.show', $agent) }}" class="btn btn-outline-info" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('agents.edit', $agent) }}" class="btn btn-outline-primary" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cartes pour mobile -->
        <div class="d-lg-none">
            <div class="row g-3">
                @foreach($agents as $agent)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="card-title fw-700">{{ $agent->prenom }} {{ $agent->nom }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-card-text"></i> {{ $agent->matricule_solde }} ·
                                    <i class="bi bi-geo-alt"></i> {{ $agent->lieu_affectation }}
                                </small>
                                <div class="mt-3">
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Dus</small>
                                            <br>
                                            <strong style="color: #667eea;">{{ $agent->jours_conges_dus }} j</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Restants</small>
                                            <br>
                                            <strong style="color: #43e97b;">{{ $agent->jours_restants }} j</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('agents.show', $agent) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Voir détails
                                    </a>
                                    <a href="{{ route('agents.edit', $agent) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $agents->links() }}
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
