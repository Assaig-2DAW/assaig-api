<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * required={"request"},
 * @OA\Xml(name="Fecha"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="fecha", type="string", readOnly="true", description="Fecha de la Reserva", example="2019-02-25"),
 * @OA\Property(property="pax", type="integer", readOnly="true", description="Capacidad del restaurante", example="30"),
 * @OA\Property(property="overbooking", type="integer", readOnly="true", description="Maximo de personas adicionales que espera el restaurate", example="5"),
 * @OA\Property(property="pax_espera", type="integer", example="5"),
 * @OA\Property(property="horario_apertura", type="string", example="14:00"),
 * @OA\Property(property="horario_cierre", type="string", example="17:00"),
 * @OA\Property(property="profesores_sala", type="string", example="[1, 2, 4]"),
 * @OA\Property(property="profesores_cocina", type="string", example="[1, 2, 4]"),
 * )
 *
 * Class Fecha
 *
 */
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

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

}
