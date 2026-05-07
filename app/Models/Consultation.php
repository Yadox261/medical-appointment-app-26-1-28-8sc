<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'treatment',
        'notes',
    ];

    // Relación con la cita
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Relación con las recetas/medicamentos
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
