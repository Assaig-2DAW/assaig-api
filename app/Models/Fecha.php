<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profesor_fecha_cocinas()
    {
        return $this->belongsToMany('App\Models\Profesor', 'profesor_fecha_cocinas', 'fecha_id', 'profesor_id')->withPivot('created_at','updated_at');
    }

    public function profesor_fecha_salas()
    {
        return $this->belongsToMany('App\Models\Profesor', 'profesor_fecha_salas', 'fecha_id', 'profesor_id')->withPivot('created_at','updated_at');
    }

}
