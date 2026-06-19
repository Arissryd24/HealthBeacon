<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertThreshold extends Model
{
    protected $fillable = [
        'patient_id','heart_rate_min','heart_rate_max',
        'oxygen_min','temperature_min','temperature_max',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}