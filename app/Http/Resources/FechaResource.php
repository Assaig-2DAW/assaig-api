<?php

namespace App\Http\Resources;

use App\Models\Profesor;
use App\Models\Profesor_fecha_cocina;
use App\Models\Profesor_fecha_sala;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class FechaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user = User::findOrFail($this->user_id);
        $profesores_fecha_sala = Profesor_fecha_sala::where('fecha_id', $this->id)->get();
        $profesores_sala = [];
        foreach ($profesores_fecha_sala as $profesor_fecha) {
            $profesores_sala[] = Profesor::findOrFail($profesor_fecha->profesor_id);
        }
        $profesores_fecha_cocina = Profesor_fecha_cocina::where('fecha_id', $this->id)->get();
        $profesores_cocina = [];
        foreach ($profesores_fecha_cocina as $profesor_fecha) {
            $profesores_cocina[] = Profesor::findOrFail($profesor_fecha->profesor_id);
        }

        return [
            'id'=> $this->id,
            'fecha'=>$this->fecha,
            'pax'=>$this->pax,
            'overbooking'=>$this->overbooking,
            'pax_espera'=>$this->pax_espera,
            'horario_apertura'=>$this->horario_apertura,
            'horario_cierre'=>$this->horario_cierre,
            'user'=>$user,
            'profesores_cocina'=>$profesores_cocina,
            'profesores_sala'=>$profesores_sala,

        ];
    }
}
