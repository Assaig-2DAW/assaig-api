<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FechaStoreRequest;
use App\Http\Requests\FechaUpdateRequest;
use App\Http\Resources\FechaCollection;
use App\Http\Resources\FechaResource;
use App\Models\Fecha;
use App\Models\Profesor_fecha_cocina;
use App\Models\Profesor_fecha_sala;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FechaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return FechaResource::collection(Fecha::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FechaStoreRequest $request)
    {
        $fecha = new Fecha();
        $fecha->fecha = $request->fecha;
        $fecha->pax = $request->pax;
        $fecha->overbooking = $request->overbooking;
        $fecha->pax_espera = $request->pax_espera;
        $fecha->horario_apertura = $request->horario_apertura;
        $fecha->horario_cierre = $request->horario_cierre;
        $fecha->user_id =  Auth::id();
        $fecha->save();

        foreach ($request->profesores_sala as $profesor) {
            $fecha->profesor_fecha_salas()->attach(intval($profesor));
        }

        foreach ($request->profesores_cocina as $profesor) {
            $fecha->profesor_fecha_cocinas()->attach(intval($profesor));
        }
        return response()->json(new FechaResource($fecha), 201);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return FechaResource
     */
    public function show(Fecha $fecha)
    {
        return new FechaResource($fecha);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FechaUpdateRequest $request, Fecha $fecha)
    {
        $fechaUpdate = Fecha::findOrFail($fecha->id);

        if(!isset($request->fecha->fecha)) {
            $fechaUpdate->fecha = $request->fecha;
        }
        $fechaUpdate->pax = $request->pax ?? $fecha->pax;
        $fechaUpdate->overbooking = $request->overbooking ?? $fecha->overbooking;
        $fechaUpdate->pax_espera = $request->pax_espera ?? $fecha->pax_espera;
        $fechaUpdate->horario_apertura = $request->horario_apertura ?? $fecha->horario_apertura;
        $fechaUpdate->horario_cierre = $request->horario_cierre ?? $fecha->horario_cierre;
        $fechaUpdate->user_id =  Auth::id();
        $fechaUpdate->save();
        if($request->profesores_sala) {
            foreach ($request->profesores_sala as $profesor) {
                $fechaUpdate->profesor_fecha_salas()->attach(intval($profesor));
            }
        }
        if($request->profesores_cocina) {
            foreach ($request->profesores_cocina as $profesor) {
                $fechaUpdate->profesor_fecha_cocinas()->attach(intval($profesor));
            }
        }
        return response()->json(new FechaResource($fechaUpdate), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Fecha $fecha)
    {
        $fecha->delete();
        return response()->json(null, 204);
    }
}
