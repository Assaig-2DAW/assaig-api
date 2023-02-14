<?php

use App\Http\Controllers\Api\AlergenoController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\ProfesorController;
use App\Http\Controllers\Api\FechaController;


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
Route::apiResource('fechas',FechaController::class)->middleware('auth:sanctum');
Route::apiResource('profesores',ProfesorController::class)->middleware('auth:sanctum');
Route::apiResource('alergenos',AlergenoController::class)->middleware('auth:sanctum');
Route::post('login', [LoginController::class,'login']);
