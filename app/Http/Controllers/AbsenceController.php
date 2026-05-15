<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Agent;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $absences = Absence::with('agent')->orderBy('created_at', 'desc')->paginate(12);

        return view('absences.index', compact('absences'));
    }

    public function create()
    {
        $agents = Agent::orderBy('nom')->get();

        return view('absences.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type' => 'required|string|max:150',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nombre_jours' => 'required|integer|min:1',
            'deductible' => 'required|boolean',
            'motif' => 'nullable|string|max:255',
        ]);

        $absence = Absence::create(array_merge($data, [
            'created_by' => auth()->id(),
        ]));

        $agent = Agent::find($data['agent_id']);
        if ($agent) {
            $agent->absences_a_defalquer += $data['nombre_jours'];
            if ($data['deductible']) {
                $agent->jours_conges_dus = max(0, $agent->jours_conges_dus - $data['nombre_jours']);
            }
            $agent->jours_restants = max(0, $agent->jours_conges_dus - $agent->jours_ouvrables_a_prendre);
            $agent->save();
        }

        return redirect()->route('absences.index')->with('success', 'Absence enregistrée avec succès.');
    }
}
