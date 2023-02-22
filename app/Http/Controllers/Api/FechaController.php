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
    /**
     * @OA\Get (
     * path="/api/fechas",
     * summary="Get all fechas",
     * description="Obtienes todas las fechas de la BBDD",
     * operationId="getFechas",
     * tags={"fechas"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=261,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="fechas", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
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
    /**
     * @OA\Post (
     * path="/api/fechas/",
     * summary="Post fecha Object",
     * description="Publicas una fecha en la  BBDD",
     * operationId="PostFecha",
     * tags={"fecha"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales para generar una fecha nueva",
     *    @OA\JsonContent(
     *       required={"fecha","pax"},
     *          @OA\Property(property="fecha", type="string", format="date", example="2023-02-24"),
     *          @OA\Property(property="pax", type="integer", example="30"),
     *          @OA\Property(property="overbooking", type="integer", example="5"),
     *          @OA\Property(property="pax_espera", type="integer", example="2"),
     *          @OA\Property(property="horario_apertura", type="string", format="time", example="14:00"),
     *          @OA\Property(property="horario_cierre", type="string", format="time", example="17:00"),
     *          @OA\Property(property="profesores_sala", type="string", format="object list of profesores", example="{1, 2, 4}"),
     *          @OA\Property(property="profesores_cocina", type="string", format="object list of profesores", example="{3, 5}"),
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
     *     response=262,
     *     description="Success",
     *     @OA\JsonContent(
     *          @OA\Property(property="fechas", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
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
        if($request->file('menu') !== null) {
            $fecha->menu = $request->file('menu');
        }
        //$fecha->user_id = Auth::id();
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
    /**
     * @OA\Get (
     * path="/api/fechas/1",
     * summary="Get a fechas",
     * description="Obtienes la fecha de la BBDD en base a la {id} enviada en la url",
     * operationId="getFecha",
     * tags={"fecha"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, profesor found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=268,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="fecha", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
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
    /**
     * @OA\Put (
     * path="/api/fechas/1",
     * summary="Update the object fecha indicated by the param $fecha",
     * description="Actualiza el objeto fecha en base al objeto $fecha pasado, primero busca si el objeto esta en la base de datos y si esta, la actualiza",
     * operationId="Update Fecha",
     * tags={"fecha"},
     * @OA\Parameter(
     *   parameter="Fecha $fecha",
     *   name="$fecha",
     *   description="Fecha to update",
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
     *     response=266,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="fecha", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
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
        //$fechaUpdate->user_id =  Auth::id();
        $fechaUpdate->save();
        $fechaUpdate->profesor_fecha_salas()->detach();
        $fechaUpdate->profesor_fecha_cocinas()->detach();
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
    /**
     * @OA\Delete (
     * path="/api/fechas/1",
     * summary="Delete the object fecha object indicated by the param {id}",
     * description="Delete the fecha object recived by the Param $fecha, first find it and aafter find it it delets",
     * operationId="Delete Fecha",
     * tags={"fecha"},
     * @OA\Parameter(
     *   parameter="Fecha $fecha",
     *   name="$fecha",
     *   description="Fecha to destroy",
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
     *     response=264,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="fecha", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
     */
    public function destroy(Fecha $fecha)
    {
        $fecha->delete();
        return response()->json(null, 204);
    }
    /**
     * @OA\Post (
     * path="/api/fechas/add-menu",
     * summary="Post the menu( img) to a indicated Fecha Object by the Id",
     * description="Publicas un menu ( una imagen) en la  BBDD usando el id pasado como fecha",
     * operationId="PostFechaAddMenu",
     * tags={"fecha"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales para generar una fecha nueva",
     *    @OA\JsonContent(
     *       required={"menu","id"},
     *          @OA\Property(property="menu", type="file", format="image"),
     *          @OA\Property(property="id", type="integer", example="1"),
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
     *     response=265,
     *     description="Success",
     *     @OA\JsonContent(
     *          @OA\Property(property="fechas", type="object", ref="app/Http/Resources/FechaResource"),
     *     )
     *  ),
     */
    public function addMenu(Request $request)
    {
        $request->validate([
            'menu' => 'required|image|mimes:jpeg,png,jpg',
            'id' => 'required|integer',
        ]);
        //dd($request->file('menu'));
        $fecha = Fecha::findOrFail($request->id);
        $file = $request->file('menu');
        $nombre =  $fecha->fecha . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $nombre);
        $fecha->menu = $nombre;
        $fecha->save();
        return response()->json(['message' => 'Menú añadido con éxito'], 201);
    }
}
