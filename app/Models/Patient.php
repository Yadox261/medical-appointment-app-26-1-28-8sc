<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'allergies',
        'chronic_diseases',
        'surgical_history',
        'family_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
    ];
    //relacion uno a uno inversa con user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //relacion uno a uno inversa con bloodtype
    public function bloodtype()
    {
        return $this->belongsTo(Bloodtype::class, 'bloodtype_id');
    }  
}
