<?php

namespace App\Actions;

use App\Models\Patient;
use App\Models\VitalSign;
use Illuminate\Support\Collection;

class DetectAnomalyAction
{
    public function execute(Patient $patient, Collection $vitals): array
    {
        $anomalies = [];
        $latest = $vitals->last();

        if (!$latest) return $anomalies;

        // Cek SpO2 rendah — 3 bacaan berturut-turut di bawah 94
        $lowSpo2 = $vitals->slice(-3)->filter(fn($v) => $v->spo2 < 94);
        if ($lowSpo2->count() >= 3) {
            $anomalies[] = [
                'alert_type' => 'SpO2 Low',
                'severity'   => 'critical',
                'message'    => "SpO2 pasien {$patient->name} di bawah 94% selama 3 bacaan berturut-turut. Nilai terakhir: {$latest->spo2}%",
            ];
        }

        // Cek detak jantung tinggi
        if ($latest->heart_rate > 120) {
            $anomalies[] = [
                'alert_type' => 'High Heart Rate',
                'severity'   => $latest->heart_rate > 140 ? 'critical' : 'medium',
                'message'    => "Detak jantung pasien {$patient->name} tinggi: {$latest->heart_rate} bpm",
            ];
        }

        // Cek tekanan darah tinggi — 2 bacaan berturut-turut
        $highBp = $vitals->slice(-2)->filter(fn($v) => $v->systolic_bp > 180);
        if ($highBp->count() >= 2) {
            $anomalies[] = [
                'alert_type' => 'High Blood Pressure',
                'severity'   => 'critical',
                'message'    => "Tekanan darah sistolik pasien {$patient->name} di atas 180 mmHg. Nilai terakhir: {$latest->systolic_bp}/{$latest->diastolic_bp}",
            ];
        }

        // Cek suhu tubuh tinggi (demam)
        if ($latest->temperature > 38.5) {
            $anomalies[] = [
                'alert_type' => 'High Temperature',
                'severity'   => $latest->temperature > 39.5 ? 'critical' : 'medium',
                'message'    => "Suhu tubuh pasien {$patient->name} tinggi: {$latest->temperature}°C",
            ];
        }

        return $anomalies;
    }
}