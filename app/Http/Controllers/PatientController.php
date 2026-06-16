<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VitalSign;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::withCount('alerts')
            ->with(['vitalSigns' => function($q) {
                $q->orderBy('recorded_at', 'desc')->take(1);
            }])
            ->orderBy('status')
            ->get();

        return Inertia::render('Patients/Index', [
        'patients' => $patients,
    
        ]);

    }

    public function show(Patient $patient)
    {
        $vitalSigns = VitalSign::where('patient_id', $patient->id)
            ->orderBy('recorded_at', 'asc')
            ->get();

        $alerts = $patient->alerts()
            ->orderBy('triggered_at', 'desc')
            ->get();

        return Inertia::render('Patients/Show', [
            'patient'    => $patient,
            'vitalSigns' => $vitalSigns,
            'alerts'     => $alerts,
        ]);
    }
}