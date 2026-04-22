<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloodtype extends Model
{
    protected $table = 'bloodtypes';

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
