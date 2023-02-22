<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * required={"request"},
 * @OA\Xml(name="Profesor"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="nombre", type="string", readOnly="true", description="Natalia Canto"),
 * @OA\Property(property="tipo", type="string", readOnly="true", description="Tipo de Profesor que es, puede ser o Cocina o Sala", example="Sala"),
 * )
 *
 * Class Profesor
 *
 */
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
