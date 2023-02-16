<?php

namespace App\Http\Resources;

use App\Http\Requests\FechaStoreRequest;
use App\Models\Fecha;
use App\Models\Profesor;

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
        //$user = $this->user()->get();
        $profesores_sala = $this->profesor_fecha_salas;
        $profesores_cocina = $this->profesor_fecha_cocinas;
        return [
            'id'=> $this->id,
            'fecha'=>$this->fecha,
            'pax'=>$this->pax,
            'overbooking'=>$this->overbooking,
            'pax_espera'=>$this->pax_espera,
            'horario_apertura'=>$this->horario_apertura,
            'horario_cierre'=>$this->horario_cierre,
            //'user'=>$user,
            'profesores_cocina'=>$profesores_cocina,
            'profesores_sala'=>$profesores_sala,

        ];
    }
}
