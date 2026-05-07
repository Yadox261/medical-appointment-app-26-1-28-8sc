<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'cedula_profesional',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con las citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relación con los horarios
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
