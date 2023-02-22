<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlergenoRequest;
use App\Http\Resources\AlergenoResource;
use App\Models\Alergeno;
use Illuminate\Http\Request;

class AlergenoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get (
     * path="/api/alergenos",
     * summary="Get all alergenos",
     * description="Obtienes todas los alergenos de la BBDD",
     * operationId="getAlergenos",
     * tags={"alergenos"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not alergenos found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=226,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="alergenos", type="object", ref="app/Http/Resources/AlergenoResource"),
     *     )
     *  ),
     */
    public function index()
    {
        return AlergenoResource::collection(Alergeno::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Save the resource in the Data Base.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post (
     * path="/api/alergenos/",
     * summary="Post alergeno Object",
     * description="Publicas un alergeno  BBDD",
     * operationId="PostAlergenos",
     * tags={"alergeno"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales para generar el alergeno",
     *    @OA\JsonContent(
     *       required={"nombre","icono"},
     *          @OA\Property(property="nombre", type="string", format="name with min:3 and max:30", example="Juan Palomo"),
     *          @OA\Property(property="icono", type="string", example="1"),
     *    ),
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
     *     response=251,
     *     description="Success",
     *     @OA\JsonContent(
     *          @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function store(AlergenoRequest $request)
    {
        $alergeno = new Alergeno();
        $alergeno->nombre = $request->nombre;
        $alergeno->icono = $request->icono;
        $alergeno->save();
        return response()->json($alergeno, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alergeno  $alergeno
     * @return AlergenoResource
     */
    /**
     * @OA\Get (
     * path="/api/alergenos/1",
     * summary="Get a alergeno",
     * description="Obtienes el alergeno de la BBDD en base a la {id} enviada en la url",
     * operationId="getAlergeno",
     * tags={"alergeno"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, profesor found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=289,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="alergeno", type="object", ref="app/Http/Resources/AlergenoResource"),
     *     )
     *  ),
     */
    public function show(Alergeno $alergeno)
    {
        return new AlergenoResource($alergeno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alergeno  $alergeno
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Put (
     * path="/api/alergenos/1",
     * summary="Update the object alrgeno indicated by the param $alergeno",
     * description="Actualiza el objeto profesor en base al objeto $alergeno pasado, primero busca si el objeto esta en la base de datos y si esta, la actualiza",
     * operationId="Update Alergeno",
     * tags={"alergeno"},
     * @OA\Parameter(
     *   parameter="Alergeno $alergeno",
     *   name="$alergeno",
     *   description="Alergeno to update",
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
     *     response=233,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="alergeno", type="object", ref="app/Http/Resources/AlergenoResource"),
     *     )
     *  ),
     */
    public function update(AlergenoRequest $request, Alergeno $alergeno)
    {
        $alergeno = Alergeno::findOrFail($alergeno->id);
        $alergeno->nombre = $request->nombre ?? $alergeno->nombre;
        $alergeno->icono = $request->icono ?? $alergeno->icono;
        $alergeno->save();
        return response()->json($alergeno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alergeno  $alergeno
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Delete (
     * path="/api/alergenos/1",
     * summary="Delete the object alergeno object indicated by the param {id}",
     * description="Delete the alergeno object recived by the Param $alergeno, first find it and aafter find it it delets",
     * operationId="Delete Alergeno",
     * tags={"alergeno"},
     * @OA\Parameter(
     *   parameter="Alergeno $alergeno",
     *   name="$alergeno",
     *   description="Alergeno to destroy",
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
     *     response=242,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="alergeno", type="object", ref="app/Http/Resources/AlergenoResource"),
     *     )
     *  ),
     */
    public function destroy(Alergeno $alergeno)
    {
        $alergeno->delete();
        return response()->json(null, 204);
    }
}
