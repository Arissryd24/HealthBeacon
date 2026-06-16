<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VitalSign;
use App\Models\Patient;
use Carbon\Carbon;

class VitalSignSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            // Generate 24 data vital per pasien (tiap 1 jam selama 24 jam terakhir)
            for ($i = 23; $i >= 0; $i--) {
                $isUnstable = $patient->status !== 'stable';

                VitalSign::create([
                    'patient_id'   => $patient->id,
                    'heart_rate'   => $isUnstable ? rand(95, 130) : rand(65, 90),
                    'systolic_bp'  => $isUnstable ? rand(150, 185) : rand(110, 130),
                    'diastolic_bp' => $isUnstable ? rand(95, 115) : rand(70, 85),
                    'spo2'         => $isUnstable ? round(rand(880, 940) / 10, 1) : round(rand(960, 999) / 10, 1),
                    'temperature'  => $isUnstable ? round(rand(378, 395) / 10, 1) : round(rand(365, 375) / 10, 1),
                    'recorded_at'  => Carbon::now()->subHours($i),
                ]);
            }
        }
    }
}