<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Alert;
use App\Models\VitalSign;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
{
    $totalPatients = Patient::count();
    $criticalCount = Patient::where('status', 'critical')->count();
    $warningCount  = Patient::where('status', 'warning')->count();
    $stableCount   = Patient::where('status', 'stable')->count();
    $activeAlerts  = Alert::where('is_active', true)->count();

    $recentAlerts = Alert::with('patient')
        ->where('is_active', true)
        ->orderBy('triggered_at', 'desc')
        ->take(5)
        ->get();

    // FIXED: Pake cara yang bener buat ambil data vital sign terbaru per pasien tanpa take(1) yang ngerusak loop
    $patients = Patient::with(['vitalSigns' => function($q) {
        $q->orderBy('id', 'desc'); // Urutkan dari ID paling baru/besar
    }])->get();

    return Inertia::render('Dashboard', [
        'stats' => [
            'total'    => $totalPatients,
            'critical' => $criticalCount,
            'warning'  => $warningCount,
            'stable'   => $stableCount,
            'alerts'   => $activeAlerts,
        ],
        'recentAlerts' => $recentAlerts,
        'patients'     => $patients,
    ]);
}
}