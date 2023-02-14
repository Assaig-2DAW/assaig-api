<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alergeno_Reserva extends Model
{
    use HasFactory;

    public function alergeno()
    {
        return $this->belongsTo(Alergeno::class, 'alergeno_id');
    }
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
