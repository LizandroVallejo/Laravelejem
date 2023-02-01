<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCategoriasController;
use App\Http\Controllers\ApiCategoriasController2;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiProductosController;
use App\Http\Controllers\ApiProductosFotosController;
use App\Http\Controllers\Ejemplocontroller;
use App\Http\Controllers\ApiAccesoController;
use App\Http\Controllers\ApiAccesoController2;

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
Route::resource('v1/login', ApiLoginController::class);
Route::resource('v1/categorias', ApiCategoriasController::class);
Route::resource('v1/categorias2', ApiCategoriasController2::class);
Route::apiResource('v1/productos', ApiProductosController::class);
Route::apiResource('v1/productos-fotos', ApiProductosFotosController::class);
Route::resource('ejemplo', Ejemplocontroller::class);
Route::resource('v1/login', ApiAccesoController::class);
Route::resource('v1/login2', ApiAccesoController2::class);