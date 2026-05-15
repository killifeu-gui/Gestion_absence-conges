@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Enregistrer une absence</div>
        <div class="card-body">
            <form method="POST" action="{{ route('absences.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Agent</label>
                    <select name="agent_id" class="form-select @error('agent_id') is-invalid @enderror">
                        <option value="">Sélectionner un agent</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->prenom }} {{ $agent->nom }} - {{ $agent->matricule_solde }}</option>
                        @endforeach
                    </select>
                    @error('agent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Date de début</label>
                        <input type="date" name="date_debut" value="{{ old('date_debut') }}" class="form-control @error('date_debut') is-invalid @enderror">
                        @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" value="{{ old('date_fin') }}" class="form-control @error('date_fin') is-invalid @enderror">
                        @error('date_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Nombre de jours</label>
                        <input type="number" name="nombre_jours" value="{{ old('nombre_jours', 1) }}" class="form-control @error('nombre_jours') is-invalid @enderror">
                        @error('nombre_jours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type d'absence</label>
                        <input type="text" name="type" value="{{ old('type', 'Absence') }}" class="form-control @error('type') is-invalid @enderror">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Déductible</label>
                        <select name="deductible" class="form-select @error('deductible') is-invalid @enderror">
                            <option value="1" {{ old('deductible') === '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('deductible') === '0' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('deductible')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Motif</label>
                    <textarea name="motif" rows="3" class="form-control">{{ old('motif') }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('absences.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
