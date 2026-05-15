@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Créer une demande de congé</div>
        <div class="card-body">
            <form method="POST" action="{{ route('leaves.store') }}">
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
                    <div class="col-md-4">
                        <label class="form-label">Date de départ</label>
                        <input type="date" name="date_debut" value="{{ old('date_debut') }}" class="form-control @error('date_debut') is-invalid @enderror">
                        @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jours ouvrables</label>
                        <input type="number" name="jours_ouvrables" value="{{ old('jours_ouvrables', 1) }}" class="form-control @error('jours_ouvrables') is-invalid @enderror">
                        @error('jours_ouvrables')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type</label>
                        <input type="text" name="type" value="{{ old('type', 'Congé annuel') }}" class="form-control @error('type') is-invalid @enderror">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Raison</label>
                        <textarea name="raison" rows="3" class="form-control">{{ old('raison') }}</textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Enfants</label>
                        <input type="number" name="enfant_count" value="{{ old('enfant_count', 0) }}" class="form-control @error('enfant_count') is-invalid @enderror">
                        @error('enfant_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Déductible</label>
                        <select name="deduit" class="form-select @error('deduit') is-invalid @enderror">
                            <option value="1" {{ old('deduit') === '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('deduit') === '0' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('deduit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
