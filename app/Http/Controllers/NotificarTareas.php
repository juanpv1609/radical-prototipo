<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tareas;
use App\Mail\TareasEmail;
use Illuminate\Support\Facades\Mail;


class NotificarTareas extends Controller
{
    public function getTareasPorNotificar()
    {
        $hoy = Carbon::now()->format('Y-m-d');

        $alerta_fechas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->where('alerta_enviada', 0)
            ->where('estado', 1)
            ->where('fecha_alerta', $hoy)
            ->get();
        return $alerta_fechas;
    }

    public function sendAlertaTareas()
    {

        $tareas = $this->getTareasPorNotificar();
        $destinatariosCC = [];

        foreach ($tareas as $item) {
            $correos = explode(",", $item->correos_alerta);
            //**!Se agrega a  auxiliar.contador@gruporadical.com a las notificaciones */

            $estructura_entregable = explode(",", $item->contrato->estructura_informe);
            //$estructura_entregable = $item->contrato->estructura_informe;

            $details = [

                'title' => 'Notificación (1ra Alerta)',
                'alerta' => 1,
                'responsable' => $item->usuario->name,
                'body' => 'Estimad@ ' . $item->usuario->name . ' el software RGSDM (Radical Gestión SDM) ha generado la siguiente alerta:',
                'entregable' => $item->descripcion,
                'cliente' => $item->contrato->cliente->nombre_comercial,
                'descripcion_contrato' => $item->contrato->descripcion,
                'observacion_contrato' => $item->contrato->observacion,
                'fecha_entrega' => $item->fecha,
                'fecha_alerta' => $item->fecha_alerta,
                'estructura_entregable' => $estructura_entregable,
                //'plazo_entrega' => (Carbon::parse($item->fecha)->diffInDays($hoy))+1,
                'plazo_entrega' => Carbon::now()->diffInDays(Carbon::parse($item->fecha), false),

                'tipo_tarea' => $item->tipo->nombre,

            ];
            foreach ($correos as $correo) {
                # code...
                array_push($destinatariosCC, $correo);
            }
            array_push($destinatariosCC, "auxiliar.contador@gruporadical.com");


            Mail::to($item->usuario->email)
                ->cc($destinatariosCC)
                ->send(new TareasEmail($details));

            $item->alerta_enviada = 1;
            $item->cuenta_alertas = $item->cuenta_alertas + 1;
            $item->save();
        }
    }

    public function getTareasPorNotificar2()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $alerta_fechas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->where('alerta_enviada', 1) //se envio la primera
            ->where('segunda_alerta_enviada', 0) // y NO se envio la segunda
            ->where('estado', 1)
            ->where('fecha', $hoy)
            ->get();
        return $alerta_fechas;
    }

    public function sendAlertaTareas2() {
        $tareas = $this->getTareasPorNotificar2();
        $destinatariosCC = [];
        foreach ($tareas as $item) {
            $correos = explode(",", $item->correos_alerta);

            //**!Se agrega a  auxiliar.contador@gruporadical.com a las notificaciones */
            //$correos = array_push($correos, "auxiliar.contador@gruporadical.com");
            $estructura_entregable = explode(",", $item->contrato->estructura_informe);

            $details = [

                'title' => 'Notificación (2da Alerta)',
                'alerta' => 2,
                'body' => 'Estimad@ '.$item->usuario->name.' el software RGSDM (Radical Gestión SDM) ha generado la siguiente alerta:',
                'entregable' => $item->descripcion,
                'cliente' => $item->contrato->cliente->nombre_comercial,
                'descripcion_contrato' => $item->contrato->descripcion,
                'observacion_contrato' => $item->contrato->observacion,
                'fecha_entrega' => $item->fecha,
                'fecha_alerta' => $item->fecha_alerta,
                'estructura_entregable' => $estructura_entregable,
                //'plazo_entrega' => (Carbon::parse($item->fecha)->diffInDays($hoy))+1,
                'plazo_entrega' => Carbon::now()->diffInDays(Carbon::parse($item->fecha),false),
                'tipo_tarea' => $item->tipo->nombre,

            ];
            foreach ($correos as $correo) {
                # code...
                array_push($destinatariosCC, $correo);
            }
            array_push($destinatariosCC, "auxiliar.contador@gruporadical.com");

            Mail::to($item->usuario->email)
            ->cc($destinatariosCC)
            ->send(new TareasEmail($details));
            $item->segunda_alerta_enviada = 1;
            $item->cuenta_alertas =$item->cuenta_alertas+1;
            $item->save();
        }
    }
}
