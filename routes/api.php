<?php

use App\Http\Controllers\Api\AlergenoController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\ProfesorController;
use App\Http\Controllers\Api\FechaController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('reservas',ReservaController::class);
Route::apiResource('fechas',FechaController::class);
Route::apiResource('profesores',ProfesorController::class);
Route::apiResource('alergenos',AlergenoController::class);
Route::post('login', [LoginController::class,'login']);
Route::get('confirmar-reserva/{id}', [ReservaController::class, 'confirmar']);
Route::get('reservas-pendientes', [ReservaController::class, 'reservasPendientes']);
Route::get('reservas-fecha/{fecha_id}', [ReservaController::class, 'reservasFecha']);
Route::get('fechas-profesor/{id}', [ProfesorController::class, 'fechasProfesor']);
Route::get('verify-email/{token}', [ReservaController::class, 'verify']);
Route::get('reservas-en-espera/{fecha_id}', [ReservaController::class, 'obtenerReservasEspera']);
Route::post('fecha/add-menu', [FechaController::class, 'addMenu']);
Route::get('/images/{filename}', function ($filename) {
    $path = public_path('images/' . $filename);
    if (!File::exists($path)) {
        return response()->json(['message' => 'Imagen no encontrada.'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
