<?php

namespace App\Actions;

use App\Models\Patient;
use App\Models\Alert;
use App\Models\Notification;

class TriggerEarlyWarningAction
{
    public function execute(Patient $patient, array $anomalies): void
    {
        foreach ($anomalies as $anomaly) {
            // Cek apakah alert yang sama sudah aktif, hindari duplikat
            $existing = Alert::where('patient_id', $patient->id)
                ->where('alert_type', $anomaly['alert_type'])
                ->where('is_active', true)
                ->first();

            if ($existing) continue;

            // Buat alert baru
            $alert = Alert::create([
                'patient_id'  => $patient->id,
                'alert_type'  => $anomaly['alert_type'],
                'severity'    => $anomaly['severity'],
                'message'     => $anomaly['message'],
                'is_active'   => true,
                'triggered_at' => now(),
            ]);

            // Update status pasien
            if ($anomaly['severity'] === 'critical') {
                $patient->update(['status' => 'critical']);
            } elseif ($anomaly['severity'] === 'medium' && $patient->status === 'stable') {
                $patient->update(['status' => 'warning']);
            }

            // Kirim notifikasi ke dokter
            Notification::create([
                'alert_id'    => $alert->id,
                'doctor_name' => $patient->doctor_name,
                'channel'     => 'system',
                'is_read'     => false,
                'sent_at'     => now(),
            ]);
        }
    }
}