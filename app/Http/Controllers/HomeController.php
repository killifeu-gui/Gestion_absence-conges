<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Absence;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'agentsCount' => Agent::count(),
            'absencesCount' => Absence::count(),
            'leavesCount' => LeaveRequest::count(),
            'latestAgents' => Agent::orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }
}
