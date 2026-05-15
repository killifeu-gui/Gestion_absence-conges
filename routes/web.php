<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Routes protégées pour admin/gestionnaire
    Route::middleware('role:admin,gestionnaire')->group(function () {
        Route::resource('agents', AgentController::class);
        Route::resource('absences', AbsenceController::class)->only(['index', 'create', 'store']);
        Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
    });
});
