<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * required={"request"},
 * @OA\Xml(name="Reserva"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="nombre", type="string", readOnly="true", description="Magicarp"),
 * @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
 * @OA\Property(property="telefono", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
 * @OA\Property(property="comensales", type="integer", maxLength=32, example="John"),
 * @OA\Property(property="observaciones", type="string", maxLength=32, example="Puede que llegemos tarde"),
 * @OA\Property(property="localizador", type="string", maxLength=32, example="5efG7"),
 * @OA\Property(property="confirmada", type="boolean", maxLength=32, example="true"),
 * @OA\Property(property="en_espera", type="boolean", maxLength=32, example="false"),
 * @OA\Property(property="verify", type="boolean", maxLength=32, example="true"),
 * @OA\Property(property="alergenos", type="object", example="['nombre': Cacauetes, 'icono': 1]"),
 * @OA\Property(property="fecha", type="string", example="2019-02-25"),
 * )
 *
 * Class Reserva
 *
 */
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
