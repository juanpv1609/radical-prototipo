<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tareas;
use App\Mail\TareasEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendSecondAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alert2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Second Alert sendend to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoy = date("Y-m-d");
        $destinatariosCC = [];

            $alerta_fechas = Tareas::with('contrato', 'frecuencias','estado_tarea','tipo','usuario')
                            ->where('alerta_enviada',1) //se envio la primera
                            ->where('segunda_alerta_enviada',0) // y NO se envio la segunda
                            ->where('estado',1)
                            ->where('fecha',$hoy)
                            ->get();
                foreach ($alerta_fechas as $item) {
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

                    /* if ($item->contrato->area_id == 3) { //SOC
                        array_push($destinatarios, 'soc.radical@gruporadical.com');
                    } else if ($item->contrato->area_id == 8) { //Infraestructura
                        array_push($destinatarios, 'infraestructura@gruporadical.com');
                    } else if ($item->contrato->area_id == 9) { //Ciberseguridad
                        array_push($destinatarios, 'soporte@gruporadical.com');
                    }

                    if ($item->contrato_id !== 9 || $item->contrato_id !== 14|| $item->contrato_id !== 12) { //utpl y jep
                        array_push($destinatarios, 'xavier.montoya@gruporadical.com');
                    }
                    if ($item->tipo_tarea==2 && $item->contrato_id==18) { // contrato COGA TEMPORAL
                        array_push($destinatarios,'cinthia.pissani@gruporadical.com');
                    } */
                    Mail::to($item->usuario->email)
                    ->cc($destinatariosCC)
                    ->send(new TareasEmail($details));
                    $item->segunda_alerta_enviada = 1;
                    $item->cuenta_alertas=$item->cuenta_alertas+1;
                    $item->save();
                }

        $this->info('Successfully sent daily quote to everyone.');
    }
}
