<?php

namespace App\Http\Resources;

use App\Models\Reserva;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $alergenos = $this->alergeno_reservas;
        $fecha = $this->fecha;
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'comensales' => $this->comensales,
            'observaciones' => $this->observaciones,
            'localizador' => $this->localizador,
            'confirmada' => $this->confirmada,
            'en_espera' => $this->en_espera,
            'verify' => $this->verify,
            'alergenos' => $alergenos,
            'fecha'=> $fecha,
        ];
    }
}
