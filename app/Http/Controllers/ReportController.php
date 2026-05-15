<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $groupBy = $request->query('group_by', 'direction');
        $agents = Agent::orderBy('lieu_affectation')->get();

        $groups = $agents->groupBy(fn ($agent) => $groupBy === 'ufr' ? ($agent->ufr ?: 'Non défini') : ($agent->direction ?: 'Non défini'));

        return view('reports.index', compact('groups', 'groupBy'));
    }

    public function exportPdf(Request $request)
    {
        $groupBy = $request->query('group_by', 'direction');
        $agents = Agent::orderBy('lieu_affectation')->get();

        $groups = $agents->groupBy(fn ($agent) => $groupBy === 'ufr' ? ($agent->ufr ?: 'Non défini') : ($agent->direction ?: 'Non défini'));

        $pdf = Pdf::loadView('reports.pdf', compact('groups', 'groupBy'));

        return $pdf->download('rapport_conges_' . now()->format('Y-m-d') . '.pdf');
    }
}
