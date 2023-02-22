<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfesorRequest;
use App\Http\Resources\FechaResource;
use App\Http\Resources\ProfesorResource;
use App\Models\Fecha;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    /**
     * @OA\Get (
     * path="/api/profesores",
     * summary="Get all profesores",
     * description="Obtienes todas los profesores de la BBDD",
     * operationId="getProfesores",
     * tags={"profesores"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=256,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="profesores", type="object", ref="app/Http/Resources/ProfesorResource"),
     *     )
     *  ),
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
    /**
     * @OA\Post (
     * path="/api/profesores/",
     * summary="Post profesor Object",
     * description="Publicas una profesor  BBDD",
     * operationId="PostProfesor",
     * tags={"profesor"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales para generar el profesor",
     *    @OA\JsonContent(
     *       required={"nombre","tipo"},
     *          @OA\Property(property="nombre", type="string", format="name with min:3 and max:50", example="Juan Palomo"),
     *          @OA\Property(property="tipo", type="string", format="sala / cocina", example="sala"),
     *    ),
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not fecha found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=212,
     *     description="Success",
     *     @OA\JsonContent(
     *          @OA\Property(property="profesores", type="object", ref="app/Http/Resources/ProfesorResource"),
     *     )
     *  ),
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
    /**
     * @OA\Get (
     * path="/api/profesores/1",
     * summary="Get a profesor",
     * description="Obtienes el profesor de la BBDD en base a la {id} enviada en la url",
     * operationId="getProfesor",
     * tags={"profesor"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, profesor found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=288,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="profesor", type="object", ref="app/Http/Resources/ProfesorResource"),
     *     )
     *  ),
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
    /**
     * @OA\Put (
     * path="/api/profesores/1",
     * summary="Update the object profesor indicated by the param $profesor",
     * description="Actualiza el objeto profesor en base al objeto $profesor pasado, primero busca si el objeto esta en la base de datos y si esta, la actualiza",
     * operationId="Update Profesor",
     * tags={"profesor"},
     * @OA\Parameter(
     *   parameter="Profesor $profesor",
     *   name="$profesor",
     *   description="Profesor to update",
     *   @OA\Schema(
     *     type="object"
     *   ),
     *   in="query",
     *   required=true
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=236,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="profesor", type="object", ref="app/Http/Resources/ProfesorResource"),
     *     )
     *  ),
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
    /**
     * Display a listing of the resource.
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete (
     * path="/api/profesor/1",
     * summary="Delete the object profesor object indicated by the param {id}",
     * description="Delete the profesor object recived by the Param $profesor, first find it and aafter find it it delets",
     * operationId="Delete Profesor",
     * tags={"profesor"},
     * @OA\Parameter(
     *   parameter="Profesor $profesor",
     *   name="$profesor",
     *   description="Profesor to destroy",
     *   @OA\Schema(
     *     type="object"
     *   ),
     *   in="query",
     *   required=true
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=241,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="profesor", type="object", ref="app/Http/Resources/ProfesorResource"),
     *     )
     *  ),
     */
    public function destroy(Profesor $profesore)
    {
        $profesore->delete();
        return response()->json(null, 204);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get (
     * path="/api/fechas-profesor/1",
     * summary="Get all profesores of a date",
     * description="Obtienes todas los profesores de la BBDD que esten en la fecha indicada por la $id",
     * operationId="fechasProfesor",
     * tags={"profesores-fechas"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=221,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="fechas", type="object", ref="app/Http/Resources/FechasResource"),
     *     )
     *  ),
     */
    public function fechasProfesor(int $id) {
        $profesor = Profesor::findOrFail($id);
        if($profesor->tipo === 'sala') {
            return FechaResource::collection($profesor->profesor_fecha_salas);
        } else {
            return FechaResource::collection($profesor->profesor_fecha_cocinas);
        }

    }
}
