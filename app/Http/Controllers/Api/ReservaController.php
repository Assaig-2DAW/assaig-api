<?php

namespace App\Http\Controllers\Api;

use App\Events\BorrarReservaEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaStoreRequest;
use App\Http\Requests\ReservaUpdateRequest;
use App\Http\Resources\ReservaResource;
use App\Jobs\ComprobarVerificacionMailProcess;
use App\Mail\ReservaDetallesMail;
use App\Mail\UnverifiedMail;
use App\Mail\VerificationMail;
use App\Models\Fecha;
use App\Models\Reserva;
use App\Models\Suscriptor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ReservaController extends Controller
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
     * path="/api/reservas",
     * summary="Get all reservas",
     * description="Obtienes todas las reservas de la BBDD",
     * operationId="getReservas",
     * tags={"reservas"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Save the resource in the Data Base.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post (
     * path="/api/reservas/",
     * summary="Post reserva Object",
     * description="Publicas una reserva  BBDD",
     * operationId="PostReservas",
     * tags={"reserva"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales para generar la reserva",
     *    @OA\JsonContent(
     *       required={"nombre","email", "telefono", "comensales", "fecha_id"},
     *          @OA\Property(property="nombre", type="string", format="name with min:3 and max:50", example="Juan Palomo"),
     *          @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *          @OA\Property(property="telefono", type="numeric", format="numeric digits: 9", example="6660283624"),
     *          @OA\Property(property="comensales", type="numeric", format="numeric min:1", example="2"),
     *          @OA\Property(property="observaciones", type="string", example="Puede ser que llegemos con algo de retraso"),
     *          @OA\Property(property="alergenos", type="object", format="Array con id de los alergenos", example="[1, 2, 5]"),
     *          @OA\Property(property="fecha_id", type="numeric", format="numeric", example="5"),
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
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     *          @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
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
        if(isset($request->subscriptor)) {
            $subscriptor = new Suscriptor();
            $subscriptor->nombre = $request->nombre;
            $subscriptor->email = $request->email;
            $subscriptor->cancelado = false;
            $subscriptor->fecha_baja = Carbon::now()->addYear();
            $subscriptor->save();
        }
        $reserva->save();
        if($request->alergenos) {
            foreach ($request->alergenos as $alergeno) {
                $reserva->alergeno_reservas()->attach(intval($alergeno));
            }
        }


        //Mail::to($request->email)->send(new VerificationMail($reserva->localizador));

        //dispatch((new ComprobarVerificacionMailProcess($reserva->id))->delay(now()->addMinute()));

        return response()->json(new ReservaResource($reserva), 201);
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get (
     * path="/api/reservas/1",
     * summary="Get a reserva",
     * description="Obtienes la reserva de la BBDD en base a la {id} enviada en la url",
     * operationId="getReserva",
     * tags={"reserva"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=202,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reserva", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function show(Reserva $reserva)
    {
        return new ReservaResource($reserva);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\JsonResponse
     */

    /**

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
     * @OA\Put (
     * path="/api/reservas/1",
     * summary="Update the object reservas indicated by the param $reserva",
     * description="Actualiza el objeto reserva en base al objeto $reserva pasado, primero busca si el objeto esta en la base de datos y si esta, la actualiza",
     * operationId="Update Reservas",
     * tags={"reserva"},
     * @OA\Parameter(
     *   parameter="Reserva $reserva",
     *   name="$reserva",
     *   description="Reserva to update",
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
     *     response=206,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
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
     * path="/api/reservas/1",
     * summary="Delete the object reservas object indicated by the param {id}",
     * description="Delete the reserva object recived by the Param $reserva, first find it and aafter find it it delets",
     * operationId="Delete Reservas",
     * tags={"reserva"},
     * @OA\Parameter(
     *   parameter="Reserva $reserva",
     *   name="$reserva",
     *   description="Reserva to destroy",
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
     *     response=204,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function destroy(Reserva $reserva)
    {
        $reserva = Reserva::findOrFail($reserva->id);
        $fecha = Fecha::findOrFail($reserva->fecha_id);
        if(!$reserva->en_espera) {
            $fecha->pax = $reserva->comensales + $fecha->pax;
            //dd($fecha);
            $fecha->save();
            $this->actualizarListaEspera($fecha);
        }
        $reserva->delete();
        return response()->json(null, 204);
    }

    function actualizarListaEspera($fecha)
    {
        $reservas_espera = Reserva::where('fecha_id', $fecha->id)
            ->where('en_espera', 1)->get();;
        //dd($reservas_espera);
        $fecha = Fecha::findOrFail($fecha->id);
        //dd($fecha);
        foreach ($reservas_espera as $reserva) {
            //dd($this->estadoReserva($fecha, $reserva->comensales));
            switch ($this->estadoReserva($fecha, $reserva->comensales)) {
                case 'aceptada':
                    $reserva->confirmada = true;
                    $reserva->en_espera = false;
                    $fecha->pax = $fecha->pax - $reserva->comensales;
                    $fecha->pax_espera = $fecha->pax_espera + 1;
                    //dd($fecha);
                    $fecha->save();
                    //dd($reserva);
                    $reserva->save();
                    break;
                case 'aceptada en overbooking':
                    $reserva->confirmada = true;
                    $reserva->en_espera = false;
                    $fecha->overbooking = $fecha->pax + $fecha->overbooking - $reserva->comensales;
                    $fecha->pax = 0;
                    $fecha->save();
                    $reserva->save();
                    break;
                case 'en espera':
                case 'denegada':
            }
        }

    }

    public function confirmar(int $id) {
        $reserva = Reserva::findOrFail($id);
        $reserva->confirmada = true;
        $reserva->save();
        return true;
    }
    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get (
     * path="/api/reservas-pendientes",
     * summary="Get a reservas which are unconfirmed",
     * description="Obtienes la reserva de la BBDD que estan pendientes",
     * operationId="getReservaPendiente",
     * tags={"reservas-pendientes"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=207,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function reservasPendientes() {
        return ReservaResource::collection(Reserva::where('confirmada', '0')->get());
    }
    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get (
     * path="/api/reservas-fecha/1",
     * summary="Get all reservas within a date",
     * description="Obtienes la reserva de la BBDD que estan en la fecha que se ha pasado",
     * operationId="getReservasFecha",
     * tags={"reservas-fecha"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=208,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
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

    public function verify($token) {
        $reserva = Reserva::where('localizador', $token)->first();
        $fecha = $reserva->fecha;
        $alergenos = $reserva->alergeno_reservas;
        if(!$reserva->verify) {
            $reserva->verify = true;
            $reserva->save();
            //Mail::to($reserva->email)->send(new ReservaDetallesMail($reserva, $fecha, $alergenos));
        }
        return view('verificateMail', compact('reserva', 'fecha', 'alergenos'));
    }

    public function comprobarVerificado($reserva_id) {
        $reserva = Reserva::findOrFail($reserva_id);
        $fecha = $reserva->fecha;
        if(!$reserva->verify) {
            $this->destroy($reserva);
            //Mail::to($reserva->email)->send(new UnverifiedMail($fecha));
            return false;
        }
        return true;
    }
    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get (
     * path="reservas-en-espera/1",
     * summary="Get a reservas within which are in state of waiting",
     * description="Obtienes la reserva de la BBDD que estan en espera",
     * operationId="getReservaEspera",
     * tags={"reservas-fecha"},
     * @OA\Response(
     *    response=400,
     *    description="Not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, not reservas found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *     response=210,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="reservas", type="object", ref="app/Http/Resources/ReservaResource"),
     *     )
     *  ),
     */
    public function obtenerReservasEspera($fecha_id)
    {
        $reservas = Reserva::where('fecha_id', $fecha_id)
            ->where('en_espera', 1)->get();
        return ReservaResource::collection($reservas);
    }

}
