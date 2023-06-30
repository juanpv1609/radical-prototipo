<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tareas;
use Illuminate\Console\Command;
use App\Mail\TareasSemanalesEmail;
use Illuminate\Support\Facades\Mail;

class SendAlertWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alert_week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia alertas pendientes para la semana';

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
        if(Carbon::now()->dayOfWeek == Carbon::MONDAY){
            $from = Carbon::now()->format('Y-m-d');
            $to = Carbon::now()->addDays(6)->format('Y-m-d');
             //$destinatarios = ['paul.canchignia@gruporadical.com','paul.landazuri@gruporadical.com','daniel.viteri@gruporadical.com','juan.perugachi@gruporadical.com'];
             $destinatarios = ['juan.perugachi@gruporadical.com','paul.canchignia@gruporadical.com'];


             $alerta_fechas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                            ->where('alerta_enviada', 0)
                            ->where('estado', 1)
                            ->whereBetween('fecha', [$from,$to])
                            ->orderBy('fecha')
                            ->get();
            //return($alerta_fechas);
            $details = [];
            $alertas=[];
                foreach ($alerta_fechas as $item) {
                    array_push($alertas, $item);
                }
                $details = ['title' => 'Notificación de entregables del '.$from.' al '.$to,
                        'alerta' => 1,
                        'body' => 'Estimad@s el software RGSDM (Radical Gestión SDM) ha generado las siguientes alertas de entregables de la semana:',
                        'alertas'=>$alertas];
                //return $details;

                Mail::to($destinatarios)
                //->cc($destinatarios)
                ->send(new TareasSemanalesEmail($details));


        $this->info('Emails enviados.');

        }else
        $this->info('Emails NO enviados.');



    }
}
