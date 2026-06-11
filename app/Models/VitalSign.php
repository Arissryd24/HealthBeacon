<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $fillable = [
        'patient_id', 'heart_rate', 'systolic_bp',
        'diastolic_bp', 'spo2', 'temperature', 'recorded_at'
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}