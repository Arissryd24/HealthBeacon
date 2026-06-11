<?php

namespace App\Actions;

use App\Models\Patient;

class ScanVitalSignsAction
{
    protected DetectAnomalyAction $detector;
    protected TriggerEarlyWarningAction $trigger;

    public function __construct()
    {
        $this->detector = new DetectAnomalyAction();
        $this->trigger  = new TriggerEarlyWarningAction();
    }

    public function execute(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            // Ambil data vital 1 jam terakhir
            $vitals = $patient->vitalSigns()
                ->where('recorded_at', '>=', now()->subHour())
                ->orderBy('recorded_at', 'asc')
                ->get();

            if ($vitals->isEmpty()) continue;

            // Deteksi anomali
            $anomalies = $this->detector->execute($patient, $vitals);

            // Trigger alert kalau ada anomali
            if (!empty($anomalies)) {
                $this->trigger->execute($patient, $anomalies);
            }
        }
    }
}