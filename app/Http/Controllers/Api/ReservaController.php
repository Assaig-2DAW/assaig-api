<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaStoreRequest;
use App\Http\Requests\ReservaUpdateRequest;
use App\Http\Resources\ReservaResource;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReservaStoreRequest $request)
    {
        $reserva = new Reserva();
        $reserva->nombre = $request->nombre;
        $reserva->email = $request->email;
        $reserva->telefono = $request->telefono;
        $reserva->comensales = $request->comensales;
        $reserva->confirmada = false;
        $reserva->localizador = "AAAAD";
        $reserva->observaciones = $request->observaciones;
        $reserva->fecha_id = $request->fecha_id;
        $reserva->save();

        foreach ($request->alergenos as $alergeno) {
            $reserva->alergeno_reservas()->attach(intval($alergeno));
        }
        return response()->json(new ReservaResource($reserva), 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return ReservaResource
     */
    public function show(Reserva $reserva)
    {
        return new ReservaResource($reserva);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ReservaUpdateRequest $request, Reserva $reserva)
    {
        $reservaUpdate = Reserva::findOrFail($reserva->id);
        $reservaUpdate->nombre = $request->nombre ?? $reserva->nombre;
        $reservaUpdate->email = $request->email ?? $reserva->email;
        $reservaUpdate->telefono = $request->telefono ?? $reserva->telefono;
        $reservaUpdate->comensales = $request->comensales ?? $reserva->comensales;
        $reservaUpdate->confirmada = $request->confirmada ?? $reserva->confirmada;
        $reservaUpdate->localizador = $reserva->localizador;
        $reservaUpdate->observaciones = $request->observaciones ?? $reserva->observaciones;
        $reservaUpdate->fecha_id = $request->fecha_id ?? $reserva->fecha_id;
        $reservaUpdate->save();
        $reserva->alergeno_reservas()->detach();
        if($request->alergenos) {
            foreach ($request->alergenos as $alergeno) {
                $reservaUpdate->alergeno_reservas()->attach(intval($alergeno));
            }
        }
        return response()->json(new ReservaResource($reservaUpdate), 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return response()->json(null, 204);
    }
}
