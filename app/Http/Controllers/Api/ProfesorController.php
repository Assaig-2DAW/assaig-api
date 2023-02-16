<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfesorRequest;
use App\Http\Resources\FechaResource;
use App\Http\Resources\ProfesorResource;
use App\Models\Fecha;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProfesorResource::collection(Profesor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProfesorRequest $request)
    {
        $profesor = new Profesor();
        $profesor->nombre = $request->nombre;
        $profesor->tipo = $request->tipo;
        $profesor->save();
        return response()->json($profesor, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return ProfesorResource
     */
    public function show(Profesor $profesore)
    {
        return new ProfesorResource($profesore);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfesorRequest $request, Profesor $profesore)
    {
        $profesore = Profesor::findOrFail($profesore->id);
        $profesore->nombre = $request->nombre ?? $profesore->nombre;
        $profesore->tipo = $request->tipo ?? $profesore->tipo;
        $profesore->save();
        return response()->json($profesore);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Profesor $profesore)
    {
        $profesore->delete();
        return response()->json(null, 204);
    }

    public function fechasProfesor(int $id) {
        $profesor = Profesor::findOrFail($id);
        if($profesor->tipo === 'sala') {
            return FechaResource::collection($profesor->profesor_fecha_salas()->get());
        } else {
            return FechaResource::collection($profesor->profesor_fecha_cocinas()->get());
        }

    }
}
