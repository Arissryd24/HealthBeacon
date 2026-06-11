<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'room_number', 'doctor_name', 
        'status', 'age', 'gender'
    ];

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}