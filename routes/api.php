<?php

use App\User;
use App\Models\CasosDeUso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\TipoTareaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CasosDeUsoController;
use App\Http\Controllers\FrecuenciaController;
use App\Http\Controllers\NivelEstudioController;
use App\Http\Controllers\PerfilPuestoController;
use App\Http\Controllers\PersonaMeritoController;
use App\Http\Controllers\CertificacionesController;
use App\Http\Controllers\DestinatarioController;
use App\Http\Controllers\NotificarTareas;
use App\Http\Controllers\PanetSLAController;

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
    Route::resource('casos-de-uso', CasosDeUsoController::class);
    Route::resource('products', ProductController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('frecuencias', FrecuenciaController::class);
    Route::resource('tareas', TareaController::class);
    Route::get('tareas/{inicial}/{final}', [TareaController::class, 'tareasPorFecha']);
    Route::get('tareas-cliente/{cliente}/{inicial}/{final}', [TareaController::class, 'tareasPorFechaCliente']);
    Route::get('tareas-adjuntos/{id}', [TareaController::class, 'tareasHistorialAdjuntos']);

    Route::get('tareas-cliente-all/{cliente}', [TareaController::class, 'tareasPorCliente']);
    Route::resource('usuarios', UserController::class);
    Route::resource('tareas-tipo', TipoTareaController::class);
    Route::get('usuarios-all', [UserController::class,'indexAll']);
    Route::post('usuario-updatePassword', [UserController::class,'usuarioUpdatePassword']);
    Route::get('frecuencias-all', [FrecuenciaController::class,'indexAll']);
    Route::resource('servicios', ServiciosController::class);


    Route::post('tareasAll', [TareaController::class,'updateGroup']); //actualiza grupo de tareas


    Route::post('subir-archivo', [TareaController::class,'subirArchivo']);

    Route::get('contrato-tareas/{id}', [TareaController::class,'contratoTareas']);


    Route::get('tipo-identificacion', [ConfigController::class,'identificacion']);
    Route::get('estado-tareas', [ConfigController::class,'estadoTareas']);
    Route::get('tipo-tareas', [ConfigController::class,'tipoTareas']);


    Route::get('get-file/{archivo}', function ($archivo) {


        //verificamos si el archivo existe y lo retornamos
        if (Storage::disk('local')->exists($archivo)) {
            return response()->download(public_path('upload/' . $archivo));
        }
        //si no se encuentra lanzamos un error 404.
        return response()->json('error',404);
});
Route::get('get-file-persona/{archivo}', function ($archivo) {


        //verificamos si el archivo existe y lo retornamos
    if (Storage::disk('local')->exists('//personal//'.$archivo)) {
        return response()->download(public_path('upload/personal/' . $archivo));
    }
    //si no se encuentra lanzamos un error 404.
    return response()->json('error', 404);
});


// send mails
    Route::get('send-mails-client/{contrato}', [SendMailController::class, 'sendMailsClient']);
    Route::get('send-mail-user/{tarea}', [SendMailController::class, 'sendMailUser']);
    //Route::get('send-mail-week', [SendMailController::class, 'sendMailAlertWeek']);



// reportes
Route::get('reporte-tareas/{inicial}/{final}', [ReportesController::class, 'reporteTareas']);
Route::get('reporte-tareas-contrato/{inicial}/{final}/{contrato}', [ReportesController::class, 'reporteTareasContrato']);
Route::get('reporte-tareas-usuario/{inicial}/{final}/{usuario}', [ReportesController::class, 'reporteTareasUsuario']);
//contratos
Route::get('reporte-contratos', [ReportesController::class, 'reporteContratos']);

    //casos de uso
Route::resource('casos-de-uso', CasosDeUsoController::class);

// PERSONAL
Route::get('estado-estudio', [ConfigController::class,'estadoEstudio']);
Route::resource('persona', PersonaController::class);
Route::post('subir-archivo-persona', [PersonaController::class,'subirArchivo']);

Route::get('persona-estudios/{id}', [PersonaController::class,'estudios']);
Route::resource('nivel-estudio', NivelEstudioController::class);
Route::get('get-nivel-estudio', [NivelEstudioController::class,'listarNiveles']);
Route::resource('certificaciones', CertificacionesController::class);
Route::resource('certificaciones', CertificacionesController::class);
Route::get('get-certificaciones', [CertificacionesController::class,'listarCertificaciones']);
Route::get('reporte-certificaciones/{certificaciones}', [ReportesController::class, 'reporteCertificaciones']);
Route::get('reporte-persona/{persona}', [ReportesController::class, 'reportePersona']);

Route::resource('perfil-puesto', PerfilPuestoController::class);
Route::resource('persona-merito', PersonaMeritoController::class);

Route::resource('marcas', MarcaController::class);
Route::resource('modalidades', ModalidadController::class);


//Destinatarios

Route::resource('destinatarios', DestinatarioController::class);

//Notificaciónes SLA ticket por cerrar

Route::get('cierreTicket/{priority}', [PanetSLAController::class, 'getSLANotification']);
Route::get('notificarTicketPorCerrar/{priority}', [PanetSLAController::class, 'sendNotificationTicket']);
Route::get('informeTecnico/{priority}', [PanetSLAController::class, 'getSLAInformeNotification']);
Route::get('notificarInforme/{priority}', [PanetSLAController::class, 'sendNotificationInforme']);

//Notificaciónes Tareas

Route::get('notificarTareas', [NotificarTareas::class, 'getTareasPorNotificar']);
Route::get('sendAlertTareas', [NotificarTareas::class, 'sendAlertaTareas']);
Route::get('notificarTareas2', [NotificarTareas::class, 'getTareasPorNotificar2']);
Route::get('sendAlertTareas2', [NotificarTareas::class, 'sendAlertaTareas2']);

});

