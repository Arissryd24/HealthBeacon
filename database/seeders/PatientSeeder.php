<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['name' => 'Budi Santoso', 'room_number' => 'A101', 'doctor_name' => 'Dr. Andi', 'age' => 45, 'gender' => 'male', 'status' => 'stable'],
            ['name' => 'Siti Rahayu', 'room_number' => 'A102', 'doctor_name' => 'Dr. Andi', 'age' => 62, 'gender' => 'female', 'status' => 'warning'],
            ['name' => 'Ahmad Fauzi', 'room_number' => 'B201', 'doctor_name' => 'Dr. Budi', 'age' => 38, 'gender' => 'male', 'status' => 'critical'],
            ['name' => 'Dewi Lestari', 'room_number' => 'B202', 'doctor_name' => 'Dr. Budi', 'age' => 55, 'gender' => 'female', 'status' => 'stable'],
            ['name' => 'Hendra Wijaya', 'room_number' => 'C301', 'doctor_name' => 'Dr. Citra', 'age' => 71, 'gender' => 'male', 'status' => 'warning'],
            ['name' => 'Rina Kusuma', 'room_number' => 'C302', 'doctor_name' => 'Dr. Citra', 'age' => 29, 'gender' => 'female', 'status' => 'stable'],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}