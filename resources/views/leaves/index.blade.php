@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row align-items-center mb-5">
        <div class="col">
            <h1 class="h2 fw-700" style="color: #2c3e50;">
                <i class="bi bi-calendar2-check-fill" style="color: #4facfe;"></i> Demandes de Congé
            </h1>
            <p class="text-muted mb-0">Gérez les demandes de congé et les jours ouvrables</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('leaves.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Nouvelle demande
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

    @if($leaves->isEmpty())
        <!-- État vide -->
        <div class="text-center py-5">
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 2rem; margin-bottom: 20px;">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="mt-3 fw-600">Aucune demande de congé</h4>
            <p class="text-muted mb-4">Les demandes de congé enregistrées apparaîtront ici</p>
            <a href="{{ route('leaves.create') }}" class="btn" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="bi bi-plus-circle"></i> Créer une demande
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
                                <th><i class="bi bi-calendar"></i> Départ</th>
                                <th><i class="bi bi-calendar"></i> Fin</th>
                                <th><i class="bi bi-hourglass"></i> Jours ouvrables</th>
                                <th><i class="bi bi-arrow-repeat"></i> Retour</th>
                                <th><i class="bi bi-tag"></i> Type</th>
                                <th><i class="bi bi-check"></i> Déductible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $leave)
                                <tr>
                                    <td>
                                        <strong>{{ $leave->agent?->prenom }} {{ $leave->agent?->nom }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $leave->date_debut->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $leave->date_fin->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                            {{ $leave->jours_ouvrables }} j
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $leave->date_reprise_service->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($leave->type) }}</span>
                                    </td>
                                    <td>
                                        @if($leave->deduit)
                                            <span class="badge bg-success"><i class="bi bi-check2"></i> Oui</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi bi-x"></i> Non</span>
                                        @endif
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
                @foreach($leaves as $leave)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="card-title fw-700">{{ $leave->agent?->prenom }} {{ $leave->agent?->nom }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $leave->date_debut->format('d/m/Y') }} → {{ $leave->date_fin->format('d/m/Y') }}
                                </small>
                                <div class="mt-3">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Jours ouvrables</small>
                                            <br>
                                            <strong>{{ $leave->jours_ouvrables }} j</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Type</small>
                                            <br>
                                            <strong>{{ ucfirst($leave->type) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Retour service</small>
                                            <br>
                                            <strong>{{ $leave->date_reprise_service->format('d/m/Y') }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Déductible</small>
                                            <br>
                                            <strong>{{ $leave->deduit ? 'Oui' : 'Non' }}</strong>
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
            {{ $leaves->links() }}
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
