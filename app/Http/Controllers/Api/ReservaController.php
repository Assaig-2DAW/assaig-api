<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaStoreRequest;
use App\Http\Requests\ReservaUpdateRequest;
use App\Http\Resources\ReservaResource;
use App\Models\Fecha;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReservaStoreRequest $request)
    {
        $fecha = Fecha::findOrFail($request->fecha_id);
        $reserva = new Reserva();
        $reserva->nombre = $request->nombre;
        $reserva->email = $request->email;
        $reserva->telefono = $request->telefono;
        $reserva->comensales = $request->comensales;
        $reserva->localizador = str_replace('/', '-', Hash::make(Str::random(40)));
        $reserva->observaciones = $request->observaciones;
        $reserva->fecha_id = $request->fecha_id;
        $reserva->verify = false;

        switch ($this->estadoReserva($fecha, $request->comensales)) {
            case 'aceptada':
                $reserva->confirmada = true;
                $reserva->en_espera = false;
                $fecha->pax -= $reserva->comensales;
                $fecha->save();
                break;
            case 'aceptada en overbooking':
                $reserva->confirmada = false;
                $reserva->en_espera = false;
                $fecha->overbooking = $fecha->pax + $fecha->overbooking - $reserva->comensales;
                $fecha->pax = 0;
                $fecha->save();
                break;
            case 'en espera':
                $reserva->confirmada = false;
                $reserva->en_espera = true;
                $fecha->pax_espera = $fecha->pax_espera -1;
                $fecha->save();
                break;
            case 'denegada':
                return response("No hay espacio para guardar la reserva");
        }
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
        $fecha = $reservaUpdate->fecha;
        if(!$reservaUpdate->en_espera) {
            $fecha->pax += $reservaUpdate->comensales;

        }

        switch ($this->estadoReserva($fecha, $request->comensales)) {
            case 'aceptada':
                $reservaUpdate->confirmada = true;
                $reservaUpdate->en_espera = false;
                $fecha->pax = $fecha->pax - $request->comensales;
                $fecha->save();
                break;
            case 'aceptada en overbooking':
                $reservaUpdate->confirmada = true;
                $reservaUpdate->en_espera = false;
                $fecha->pax = $fecha->pax - $request->comensales;
                $fecha->save();
                break;
            case 'en espera':
                $reservaUpdate->confirmada = false;
                $reservaUpdate->en_espera = true;
                $fecha->pax_espera = $fecha->pax_espera -1;
                $fecha->save();
                break;
            case 'denegada':
                return response("No hay espacio para guardar la reserva");

        }
        $reservaUpdate->nombre = $request->nombre ?? $reservaUpdate->nombre;
        $reservaUpdate->email = $request->email ?? $reservaUpdate->email;
        $reservaUpdate->telefono = $request->telefono ?? $reservaUpdate->telefono;
        $reservaUpdate->comensales = $request->comensales ?? $reservaUpdate->comensales;
        $reservaUpdate->observaciones = $request->observaciones ?? $reservaUpdate->observaciones;
        $reservaUpdate->save();
        $reservaUpdate->alergeno_reservas()->detach();
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
        $reserva = Reserva::findOrFail($reserva->id);
        if(!$reserva->en_espera) {
            $fecha = $reserva->fecha;
            $fecha->pax += $reserva->comensales;
            $fecha->save();
        }
        $reserva->delete();
        return response()->json(null, 204);
    }

    public function confirmar(int $id) {
        $reserva = Reserva::findOrFail($id);
        $reserva->confirmada = true;
        $reserva->save();
        return true;
    }

    public function reservasPendientes() {
        return ReservaResource::collection(Reserva::where('confirmada', '0')->get());
    }

    public function reservasFecha(int $fecha_id) {
        return ReservaResource::collection(Reserva::where('fecha_id', $fecha_id)->get());
    }

    public function estadoReserva(Fecha $fecha, int $comensales)
    {
        if($fecha->pax >= $comensales) {
            return 'aceptada';
        }
        if($fecha->pax + $fecha->overbooking >= $comensales) {
            return 'aceptada en overbooking';
        }
        if($fecha->pax_espera > 0) {
            return 'en espera';
        }
        return 'denegada';
    }

    public function verify(String $token) {
        $reserva = Reserva::where('localizador', $token)->first();
        $reserva->verify = true;
        $reserva->save();
        return true;
    }



}
