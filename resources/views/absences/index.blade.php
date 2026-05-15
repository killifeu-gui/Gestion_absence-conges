@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row align-items-center mb-5">
        <div class="col">
            <h1 class="h2 fw-700" style="color: #2c3e50;">
                <i class="bi bi-x-circle-fill" style="color: #f5576c;"></i> Absences Autorisées
            </h1>
            <p class="text-muted mb-0">Enregistrez et gérez les absences du personnel</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('absences.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Nouvelle absence
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

    @if($absences->isEmpty())
        <!-- État vide -->
        <div class="text-center py-5">
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 2rem; margin-bottom: 20px;">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="mt-3 fw-600">Aucune absence enregistrée</h4>
            <p class="text-muted mb-4">Les absences enregistrées apparaîtront ici</p>
            <a href="{{ route('absences.create') }}" class="btn" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Enregistrer une absence
            </a>
        </div>
    @else
        <!-- Tableau responsive -->
        <div class="d-none d-lg-block">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light" style="border-top: none;">
                            <tr>
                                <th><i class="bi bi-person"></i> Agent</th>
                                <th><i class="bi bi-calendar"></i> Début</th>
                                <th><i class="bi bi-calendar"></i> Fin</th>
                                <th><i class="bi bi-hourglass"></i> Jours</th>
                                <th><i class="bi bi-tag"></i> Type</th>
                                <th><i class="bi bi-check"></i> Déductible</th>
                                <th><i class="bi bi-chat"></i> Motif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absences as $absence)
                                <tr>
                                    <td>
                                        <strong>{{ $absence->agent?->prenom }} {{ $absence->agent?->nom }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $absence->date_debut->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $absence->date_fin->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ $absence->nombre_jours }} j</span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: {{ $absence->type === 'maladie' ? '#667eea' : ($absence->type === 'permission' ? '#4facfe' : '#43e97b') }};">
                                            {{ ucfirst($absence->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($absence->deductible)
                                            <span class="badge bg-danger"><i class="bi bi-check2"></i> Oui</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi bi-x"></i> Non</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($absence->motif, 30) }}</small>
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
                @foreach($absences as $absence)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="card-title fw-700">{{ $absence->agent?->prenom }} {{ $absence->agent?->nom }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $absence->date_debut->format('d/m/Y') }} → {{ $absence->date_fin->format('d/m/Y') }}
                                </small>
                                <div class="mt-3">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Nombre de jours</small>
                                            <br>
                                            <strong>{{ $absence->nombre_jours }} j</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Type</small>
                                            <br>
                                            <strong>{{ ucfirst($absence->type) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Déductible</small>
                                            <br>
                                            <strong>{{ $absence->deductible ? 'Oui' : 'Non' }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Motif</small>
                                            <br>
                                            <strong class="text-truncate">{{ Str::limit($absence->motif, 15) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $absences->links() }}
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
