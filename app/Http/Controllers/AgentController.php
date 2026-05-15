<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $agents = Agent::orderBy('nom')->paginate(12);

        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule_solde' => 'required|string|max:100|unique:agents,matricule_solde',
            'lieu_affectation' => 'required|string|max:255',
            'direction' => 'nullable|string|max:255',
            'ufr' => 'nullable|string|max:255',
            'date_prise_service' => 'required|date',
            'date_cessation_service' => 'nullable|date',
            'date_reprise_service' => 'nullable|date',
            'jours_conges_dus' => 'required|integer|min:0',
            'jours_ouvrables_a_prendre' => 'required|integer|min:0',
            'absences_a_defalquer' => 'required|integer|min:0',
            'enfants' => 'required|integer|min:0',
        ]);

        $data['jours_conges_dus'] += $data['enfants'];
        $data['jours_restants'] = max(0, $data['jours_conges_dus'] - $data['jours_ouvrables_a_prendre']);

        Agent::create($data);

        return redirect()->route('agents.index')->with('success', 'Agent ajouté avec succès.');
    }

    public function show(Agent $agent)
    {
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule_solde' => 'required|string|max:100|unique:agents,matricule_solde,' . $agent->id,
            'lieu_affectation' => 'required|string|max:255',
            'direction' => 'nullable|string|max:255',
            'ufr' => 'nullable|string|max:255',
            'date_prise_service' => 'required|date',
            'date_cessation_service' => 'nullable|date',
            'date_reprise_service' => 'nullable|date',
            'jours_conges_dus' => 'required|integer|min:0',
            'jours_ouvrables_a_prendre' => 'required|integer|min:0',
            'absences_a_defalquer' => 'required|integer|min:0',
            'enfants' => 'required|integer|min:0',
        ]);

        $data['jours_conges_dus'] += $data['enfants'];
        $data['jours_restants'] = max(0, $data['jours_conges_dus'] - $data['jours_ouvrables_a_prendre']);

        $agent->update($data);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent supprimé.');
    }
}
