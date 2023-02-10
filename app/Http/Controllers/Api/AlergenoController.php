<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        return AlergenoResource::collection(Alergeno::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
    public function show(Alergeno $alergeno)
    {
        return new AlergenoResource($alergeno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alergeno  $alergeno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alergeno $alergeno)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alergeno $alergeno)
    {
        $alergeno->delete();
        return response()->json(null, 204);
    }
}
