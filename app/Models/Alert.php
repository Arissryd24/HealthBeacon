<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'patient_id', 'alert_type', 'severity',
        'message', 'is_active', 'triggered_at', 'resolved_at'
    ];

    protected $casts = [
        'triggered_at' => 'datetime',
        'resolved_at'  => 'datetime',
        'is_active'    => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}