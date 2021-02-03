<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrecuenciaController;

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

Route::middleware('api')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('frecuencias', FrecuenciaController::class);




});

