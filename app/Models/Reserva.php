<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    public function fecha()
    {
        return $this->belongsTo(Fecha::class, 'fecha_id');
    }

    public function alergeno_reservas()
    {
        return $this->belongsToMany('App\Models\Alergeno', 'alergeno_reservas', 'reserva_id', 'alergeno_id')->withPivot('created_at','updated_at');
    }
}
