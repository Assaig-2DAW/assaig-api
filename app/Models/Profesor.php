<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    public function profesor_fecha_cocinas()
    {
        return $this->belongsToMany('App\Models\Fecha', 'profesor_fecha_cocinas', 'profesor_id', 'fecha_id')->withPivot('created_at','updated_at');
    }
    public function profesor_fecha_salas()
    {
        return $this->belongsToMany('App\Models\Fecha', 'profesor_fecha_salas', 'profesor_id', 'fecha_id')->withPivot('created_at','updated_at');
    }
}
