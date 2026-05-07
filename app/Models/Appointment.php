<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relación con el paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relación con el doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relación con la consulta
    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    // Accessor para el nombre del estatus
    public function getStatusLabelAttribute(): string
    {
        return match ((int) $this->status) {
            1 => 'Programado',
            2 => 'Completado',
            3 => 'Cancelado',
            default => 'Desconocido',
        };
    }

    // Accessor para el color del badge del estatus
    public function getStatusColorAttribute(): string
    {
        return match ((int) $this->status) {
            1 => 'blue',
            2 => 'green',
            3 => 'red',
            default => 'gray',
        };
    }
}
