<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('vital_signs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
        $table->integer('heart_rate');        // detak jantung (bpm)
        $table->integer('systolic_bp');       // tekanan darah atas
        $table->integer('diastolic_bp');      // tekanan darah bawah
        $table->decimal('spo2', 5, 2);        // saturasi oksigen (%)
        $table->decimal('temperature', 4, 1); // suhu tubuh (°C)
        $table->timestamp('recorded_at');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
