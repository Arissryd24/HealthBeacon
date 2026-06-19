<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlertThreshold;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminThresholdController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Threshold/Index', [
            'thresholds' => AlertThreshold::with('patient:id,name')->get(),
            'patients'   => Patient::select('id','name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'      => 'nullable|exists:patients,id',
            'heart_rate_min'  => 'required|numeric',
            'heart_rate_max'  => 'required|numeric',
            'oxygen_min'      => 'required|numeric',
            'temperature_min' => 'required|numeric',
            'temperature_max' => 'required|numeric',
        ]);

        AlertThreshold::updateOrCreate(
            ['patient_id' => $request->patient_id],
            $validated
        );

        return redirect()->route('admin.thresholds.index')->with('success', 'Threshold disimpan.');
    }

    public function update(Request $request, AlertThreshold $threshold)
    {
        $threshold->update($request->validate([
            'heart_rate_min'  => 'required|numeric',
            'heart_rate_max'  => 'required|numeric',
            'oxygen_min'      => 'required|numeric',
            'temperature_min' => 'required|numeric',
            'temperature_max' => 'required|numeric',
        ]));

        return redirect()->route('admin.thresholds.index')->with('success', 'Threshold diperbarui.');
    }
}