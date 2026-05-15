<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des congés - {{ now()->format('d/m/Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 30px; }
        h2 { margin-top: 30px; border-bottom: 2px solid #333; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .group-header { background-color: #e9ecef; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <h1>Rapport des congés du personnel universitaire</h1>
    <p><strong>Date de génération :</strong> {{ now()->format('d/m/Y H:i') }}</p>
    <p><strong>Grouper par :</strong> {{ $groupBy === 'direction' ? 'Direction' : 'UFR' }}</p>

    @foreach($groups as $groupName => $agents)
        <h2>{{ $groupName }} ({{ $agents->count() }} agent{{ $agents->count() > 1 ? 's' : '' }})</h2>

        <table>
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
    @endforeach

    <div class="footer">
        <p>Généré par la plateforme de gestion des absences et congés</p>
        <p>Université du Sénégal</p>
    </div>
</body>
</html>
