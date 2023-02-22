<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * required={"request"},
 * @OA\Xml(name="Alergeno"),
 * @OA\Property(property="nombre", type="integer", readOnly="true", example="Cacauetes"),
 * @OA\Property(property="icono", type="string", readOnly="true", description="User role"),

 * )
 *
 * Class Alergenos
 *
 */
class Alergeno extends Model
{
    use HasFactory;

    public function alergeno_reservas()
    {
        return $this->belongsToMany('App\Models\Reserva', 'alergeno_reservas', 'alergeno_id', 'reserva_id')->withPivot('created_at','updated_at');

    }
}
