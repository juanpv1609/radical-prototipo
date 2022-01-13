<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tareas;
use App\Models\Contrato;
use App\Mail\TareasEmail;
use App\Mail\TicketEmail;
use App\Mail\FinContratoEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketFinalizacionContratoEmail;

class SendAlertEndContract60 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alertendcontract60';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the alert is sent when a contract is one month (60 days) away from ending '; //se envia la alerta cuando un contrato esta a un mes de terminar

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
        $hoy = Carbon::now()->format('Y-m-d');

        $destinatarios = ['paul.canchignia@gruporadical.com','fabian.ortega@gruporadical.com','xavier.montoya@gruporadical.com'];
        $cc=['teamsoc@gruporadical.com','ana.rivera@gruporadical.com'];

             $alerta_fechas = Contrato::with('cliente')
                            ->where('alerta_fin_contrato30',0) // no se ah enviado la alerta
                            ->where('estado',1) // el contrato esta activo
                            ->where('fecha_fin',Carbon::now()->addDays(60)->format('Y-m-d')) // fecha finalizacion es hoy + 30 dias
                            //->where('fecha_fin','2021-08-26') // fecha finalizacion es hoy + 30 dias
                            ->get();
                foreach ($alerta_fechas as $item) {
                    $details = [

                        'title' => 'Notificación de finalización de operaciones (1ra Alerta)',
                        'alerta' => 1,
                        //'responsable' => $item->usuario->name,
                        'body' => 'Estimad@ el software RGSDM (Radical Gestión SDM) ha generado la siguiente alerta: ',

                        //'entregable' => $item->descripcion,
                        'cliente' => $item->cliente->nombre_comercial,
                        'descripcion_contrato' => $item->descripcion,
                        'observacion_contrato' => $item->observacion,
                        'fecha_inicio' => $item->fecha_inicio,
                        'fecha_fin' => $item->fecha_fin,
                        //'plazo_entrega' => (Carbon::parse($item->fecha)->diffInDays($hoy))+1,
                        'plazo_finalizacion' => Carbon::now()->diffInDays(Carbon::parse($item->fecha_fin),false),

                        //'tipo_tarea' => $item->tipo->nombre,

                    ];



                    Mail::to($destinatarios)
                    ->cc($cc)
                    ->send(new FinContratoEmail($details));


                    // SOLICITUD APERTURA DE TICKET
                    //Mail::to('soporte@gruporadical.com')
                    //->cc('paul.canchignia@gruporadical.com')
                    //->send(new TicketFinalizacionContratoEmail($details));
                    $item->alerta_fin_contrato60 = 1;
                    //$item->cuenta_alertas=$item->cuenta_alertas+1;
                    $item->save();
                }

        $this->info('Successfully sent daily quote to everyone.');
    }
}
