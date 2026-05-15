@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Modifier un agent</div>
        <div class="card-body">
            <form method="POST" action="{{ route('agents.update', $agent) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $agent->nom) }}" class="form-control @error('nom') is-invalid @enderror">
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $agent->prenom) }}" class="form-control @error('prenom') is-invalid @enderror">
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Matricule de solde</label>
                        <input type="text" name="matricule_solde" value="{{ old('matricule_solde', $agent->matricule_solde) }}" class="form-control @error('matricule_solde') is-invalid @enderror">
                        @error('matricule_solde')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lieu d'affectation</label>
                        <input type="text" name="lieu_affectation" value="{{ old('lieu_affectation', $agent->lieu_affectation) }}" class="form-control @error('lieu_affectation') is-invalid @enderror">
                        @error('lieu_affectation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Direction</label>
                        <input type="text" name="direction" value="{{ old('direction', $agent->direction) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">UFR</label>
                        <input type="text" name="ufr" value="{{ old('ufr', $agent->ufr) }}" class="form-control">
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Date de prise de service</label>
                        <input type="date" name="date_prise_service" value="{{ old('date_prise_service', optional($agent->date_prise_service)->format('Y-m-d')) }}" class="form-control @error('date_prise_service') is-invalid @enderror">
                        @error('date_prise_service')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date de cessation de service</label>
                        <input type="date" name="date_cessation_service" value="{{ old('date_cessation_service', optional($agent->date_cessation_service)->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date de reprise de service</label>
                        <input type="date" name="date_reprise_service" value="{{ old('date_reprise_service', optional($agent->date_reprise_service)->format('Y-m-d')) }}" class="form-control">
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-3">
                        <label class="form-label">Jours de congés dus</label>
                        <input type="number" name="jours_conges_dus" value="{{ old('jours_conges_dus', $agent->jours_conges_dus) }}" class="form-control @error('jours_conges_dus') is-invalid @enderror">
                        @error('jours_conges_dus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jours ouvrables à prendre</label>
                        <input type="number" name="jours_ouvrables_a_prendre" value="{{ old('jours_ouvrables_a_prendre', $agent->jours_ouvrables_a_prendre) }}" class="form-control @error('jours_ouvrables_a_prendre') is-invalid @enderror">
                        @error('jours_ouvrables_a_prendre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Absences à déduire</label>
                        <input type="number" name="absences_a_defalquer" value="{{ old('absences_a_defalquer', $agent->absences_a_defalquer) }}" class="form-control @error('absences_a_defalquer') is-invalid @enderror">
                        @error('absences_a_defalquer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nombre d'enfants</label>
                        <input type="number" name="enfants" value="{{ old('enfants', $agent->enfants) }}" class="form-control @error('enfants') is-invalid @enderror">
                        @error('enfants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('agents.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
