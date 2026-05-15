@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Rapports administratifs</h3>
        <div>
            <form method="GET" action="{{ route('reports.index') }}" class="d-flex gap-2">
                <select name="group_by" class="form-select">
                    <option value="direction" {{ $groupBy === 'direction' ? 'selected' : '' }}>Par direction</option>
                    <option value="ufr" {{ $groupBy === 'ufr' ? 'selected' : '' }}>Par UFR</option>
                </select>
                <button class="btn btn-primary">Filtrer</button>
            </form>
            <a href="{{ route('reports.export', ['group_by' => $groupBy]) }}" class="btn btn-success ms-2">Exporter PDF</a>
        </div>
    </div>

    @foreach($groups as $groupName => $agents)
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">{{ $groupName }} ({{ $agents->count() }})</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Matricule</th>
                                <th>Congés dus</th>
                                <th>À prendre</th>
                                <th>Restants</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                                <tr>
                                    <td>{{ $agent->prenom }} {{ $agent->nom }}</td>
                                    <td>{{ $agent->matricule_solde }}</td>
                                    <td>{{ $agent->jours_conges_dus }}</td>
                                    <td>{{ $agent->jours_ouvrables_a_prendre }}</td>
                                    <td>{{ $agent->jours_restants }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    @if($groups->isEmpty())
        <div class="alert alert-warning">Aucun agent trouvé pour ce rapport.</div>
    @endif
</div>
@endsection
