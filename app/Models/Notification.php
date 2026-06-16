<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'alert_id', 'doctor_name', 'channel',
        'is_read', 'sent_at'
    ];

    protected $casts = [
        'sent_at'  => 'datetime',
        'is_read'  => 'boolean',
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}