<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tareas;
use App\Models\Contrato;
use App\Mail\TareasEmail;
use App\Mail\TicketEmail;
use App\Mail\ContratoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index()
    {
        //
    }
    public function sendMailsClient($contrato_id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'tarea')->find($contrato_id);
        $correos = explode(",", $contrato->correos);
        $details = [

            'title' => 'Nuevo contrato registrato',
            'body' => 'Se ha registrado un nuevo contrato, a continuacion los detalles',
            'cliente' => $contrato->cliente->razon_social,
            'fecha_inicio' => $contrato->fecha_inicio,
            'fecha_fin' => $contrato->fecha_fin,
            'area' => $contrato->area->nombre,
            'solucion' => $contrato->solucion,

        ];
        foreach ($correos as $correo) {
            Mail::to($correo)->send(new ContratoEmail($details));
        }
    }
    public function sendMailUser($tarea_id)
    {
        $destinatarios = ['paul.canchignia@gruporadical.com'];

        $tarea = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->find($tarea_id);
        //->whereRaw('fecha_alerta = curdate()')->get();
        //dd($tarea);
        $details = [

            'title' => 'Notificación de entregable (1ra Alerta)',
            'alerta' => 1,
            'responsable' => $tarea->usuario->name,
            'body' => 'Estimad@ ' . $tarea->usuario->name . ' el software RGSDM (Radical Gestión SDM) ha generado la siguiente alerta:',
            'entregable' => $tarea->descripcion,
            'cliente' => $tarea->contrato->cliente->nombre_comercial,
            'descripcion_contrato' => $tarea->contrato->descripcion,
            'observacion_contrato' => $tarea->contrato->observacion,
            'fecha_entrega' => $tarea->fecha,
            'fecha_alerta' => $tarea->fecha_alerta,
            //'plazo_entrega' => Carbon::parse($tarea->fecha)->diffForHumans(Carbon::now()),
            'plazo_entrega' => Carbon::now()->diffInDays(Carbon::parse($tarea->fecha), false),
            'tipo_tarea' => $tarea->tipo->nombre,

        ];

        if ($tarea->contrato->area_id == 3) { //SOC
            array_push($destinatarios, 'soc.radical@gruporadical.com');
        } else if ($tarea->contrato->area_id == 8) { //Infraestructura
            array_push($destinatarios, 'infraestructura@gruporadical.com');
        } else if ($tarea->contrato->area_id == 9) { //Ciberseguridad
            array_push($destinatarios, 'soporte@gruporadical.com');
        }

        if ($tarea->contrato_id !== 9 || $tarea->contrato_id !== 14 || $item->contrato_id !== 12) { //utpl y jep
            array_push($destinatarios, 'xavier.montoya@gruporadical.com');
        }
        if ($tarea->tipo_tarea == 2 && $tarea->contrato_id == 18) { // contrato COGA TEMPORAL
            array_push($destinatarios, 'cinthia.pissani@gruporadical.com');
        }
        //dd($destinatarios);
        Mail::to($tarea->usuario->email)
            ->cc($destinatarios)
            ->send(new TareasEmail($details));
        // SOLICITUD APERTURA DE TICKET
        Mail::to('soporte@gruporadical.com')
            //->cc('paul.canchignia@gruporadical.com')
            ->send(new TicketEmail($details));
        $tarea->alerta_enviada = 1;
        $tarea->cuenta_alertas = $tarea->cuenta_alertas + 1;

        $tarea->save();

        //$this->info('Successfully sent daily quote to everyone.');
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
