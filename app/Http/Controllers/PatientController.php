<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VitalSign;
use Inertia\Inertia;
use Illuminate\Http\Request;

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

    // --- FITUR TAMBAH PASIEN (Sesuai struktur model Anda) ---
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|string',
            // Tambahkan field lain jika ada di tabel pasien Anda
        ]);

        Patient::create($validated);

        return redirect()->back()->with('message', 'Pasien berhasil ditambahkan.');
    }

    // --- FITUR HAPUS PASIEN ---
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->back()->with('message', 'Pasien berhasil dihapus.');
    }
}