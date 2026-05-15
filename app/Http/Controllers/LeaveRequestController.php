<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $leaves = LeaveRequest::with('agent')->orderBy('created_at', 'desc')->paginate(12);

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $agents = Agent::orderBy('nom')->get();

        return view('leaves.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'date_debut' => 'required|date',
            'jours_ouvrables' => 'required|integer|min:1',
            'type' => 'required|string|max:150',
            'raison' => 'nullable|string|max:255',
            'enfant_count' => 'nullable|integer|min:0',
            'deduit' => 'required|boolean',
        ]);

        $holidays = Holiday::pluck('date')->map(fn($date) => Carbon::parse($date)->toDateString())->toArray();
        $startDate = Carbon::parse($data['date_debut']);
        $data['date_fin'] = $this->calculateEndDate($startDate, $data['jours_ouvrables'], $holidays)->toDateString();
        $data['date_reprise_service'] = $this->nextWorkday(Carbon::parse($data['date_fin'])->addDay(), $holidays)->toDateString();

        $leaveRequest = LeaveRequest::create($data);

        $agent = Agent::find($data['agent_id']);
        if ($agent) {
            $agent->jours_ouvrables_a_prendre += $data['jours_ouvrables'];
            if ($data['deduit']) {
                $agent->jours_conges_dus = max(0, $agent->jours_conges_dus - $data['jours_ouvrables']);
            }
            $agent->jours_restants = max(0, $agent->jours_conges_dus - $agent->jours_ouvrables_a_prendre);
            $agent->save();
        }

        return redirect()->route('leaves.index')->with('success', 'Demande de congé créée avec succès.');
    }

    private function calculateEndDate(Carbon $date, int $workDays, array $holidays): Carbon
    {
        $count = 0;
        $current = $date->copy();

        while ($count < $workDays) {
            if ($this->isWorkday($current, $holidays)) {
                $count++;
            }
            if ($count >= $workDays) {
                break;
            }
            $current->addDay();
        }

        return $current;
    }

    private function nextWorkday(Carbon $date, array $holidays): Carbon
    {
        while (! $this->isWorkday($date, $holidays)) {
            $date->addDay();
        }

        return $date;
    }

    private function isWorkday(Carbon $date, array $holidays): bool
    {
        if ($date->isSunday()) {
            return false;
        }

        if (in_array($date->toDateString(), $holidays, true)) {
            return false;
        }

        return true;
    }
}
