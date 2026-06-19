<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\VitalSign;
use App\Actions\ScanVitalSignsAction;
use Inertia\Inertia;

class VitalSignController extends Controller
{
    public function create()
    {
        // Ambil semua pasien dari DB buat dilempar ke dropdown Vue
        return Inertia::render('VitalSignForm', [
            'patients' => Patient::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'spo2' => 'required|numeric',
            'heart_rate' => 'required|numeric',
            'temperature' => 'required|numeric',
            'systolic_bp' => 'required|numeric',
            'diastolic_bp' => 'required|numeric',
        ]);

        $validated['recorded_at'] = now();
        VitalSign::create($validated);

        // TRIGGER AGEN: Deteksi otomatis langsung jalan
        app(ScanVitalSignsAction::class)->execute();

        // Redirect balik ke dashboard utama biar kelihatan efek warnanya berubah
        return redirect()->route('dashboard')->with('success', 'Data masuk! Agen sukses mengupdate status pasien.');
    }

   public function destroy($id)
{
    // Mengantisipasi kalau ID yang dikirim berbentuk objek atau array dari Vue
    $cleanId = is_array($id) ? ($id['id'] ?? null) : $id;

    if (!$cleanId) {
        return redirect()->back()->with('error', 'ID valid gak ketangkap, bro.');
    }

    // Cari data vital sign
    $vitalSign = VitalSign::find($cleanId);

    if ($vitalSign) {
        $patientId = $vitalSign->patient_id;

        // 1. Hapus data vital sign
        $vitalSign->delete();

        // 2. Update status pasien balik jadi stable
        $patient = Patient::find($patientId);
        if ($patient) {
            $patient->status = 'stable';
            $patient->save();
        }

        // 3. Hapus alert aktif biar bersih
        \App\Models\Alert::where('patient_id', $patientId)->delete();

        // PENTING: Pake redirect()->back() biar Inertia otomatis memperbarui state komponen Vue
        return redirect()->back()->with('message', 'Data berhasil dihapus, bro!');
    }

    return redirect()->back()->with('error', 'Data gagal dihapus atau gak ketemu.');
}
}