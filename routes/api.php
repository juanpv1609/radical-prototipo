<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\TipoTareaController;
use App\Http\Controllers\Auth\LoginController;
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





// Route::middleware('api')->get('user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::post('login', [LoginController::class,'login']);
    Route::post('logout', [LoginController::class,'logout']);




    Route::resource('contratos', ContratoController::class);
    Route::resource('products', ProductController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('frecuencias', FrecuenciaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('tareas', TareaController::class);
    Route::resource('usuarios', UserController::class);
    Route::resource('tareas-tipo', TipoTareaController::class);
    Route::get('usuarios-all', [UserController::class,'indexAll']);
    Route::post('usuario-updatePassword', [UserController::class,'usuarioUpdatePassword']);


    Route::post('tareasAll', [TareaController::class,'updateGroup']); //actualiza grupo de tareas


    Route::post('subir-archivo', [TareaController::class,'subirArchivo']);

    Route::get('contrato-tareas/{id}', [TareaController::class,'contratoTareas']);


    Route::get('tipo-identificacion', [ConfigController::class,'identificacion']);
    Route::get('estado-tareas', [ConfigController::class,'estadoTareas']);
    Route::get('tipo-tareas', [ConfigController::class,'tipoTareas']);


    Route::get('get-file/{archivo}', function ($archivo) {
        $url = url('/') . '/public/upload/'.$archivo;
        $headers = array(
                    'Content-Type'=> 'application/pdf'
                    );

        //verificamos si el archivo existe y lo retornamos
        if (Storage::disk('local')->exists($archivo)) {
            return response()->download(public_path('upload/' . $archivo));
        }
        //si no se encuentra lanzamos un error 404.
        return response()->json('error',404);
});


// send mails
    Route::get('send-mails-client/{contrato}', [SendMailController::class, 'sendMailsClient']);


// reportes
Route::get('reporte-tareas/{inicial}/{final}', [ReportesController::class, 'reporteTareas']);



});

