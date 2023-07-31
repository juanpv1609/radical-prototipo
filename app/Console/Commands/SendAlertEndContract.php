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
use App\Models\ContratoDestinatario;
use App\Models\Destinatario;

class SendAlertEndContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alertendcontract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the alert is sent when a contract is one month (0 days) away from ending '; //se envia la alerta cuando un contrato esta a un mes de terminar

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

        /*$destinatarios = ['paul.canchignia@gruporadical.com','fabian.ortega@gruporadical.com',
                            'xavier.montoya@gruporadical.com','norma.veloz@gruporadical.com',
                            'jm.gomez@gruporadical.com','cristina.jimenez@gruporadical.com',
                            'nelson.morales@gruporadical.com','tatiana.pazos@gruporadical.com', 'catherine.stopar@gruporadical.com'];*/

        /*$destinatarios = [];

        $email_destinatario = ContratoDestinatario::with('destinatarios')
            ->where('estado', 1)

            ->get();
            foreach ($email_destinatario as $item) {
                array_push($destinatarios, $item->destinatarios->email);
            }*/


        $email_cliente = "";

        /*$destinatarios = Destinatario::where('is_deleted', 0)
            ->pluck('email')
            ->toArray();*/

        $alerta_fechas = Contrato::with('cliente')
            //->where('alerta_fin_contrato30',0) // se envio la alerta de 30 dias
            ->where('alerta_fin_contrato', 0) // no se ah enviado la alerta
            ->where('estado', 1) // el contrato esta activo
            ->where('fecha_fin', Carbon::now()->format('Y-m-d')) // fecha finalizacion es hoy
            //->where('fecha_fin','2021-08-26') // fecha finalizacion es hoy + 30 dias
            ->get();
        foreach ($alerta_fechas as $item) {
            $email_cliente = $item->cliente->correo;
            
            //Enviar el correo con copia a los destinatarios elegidos.
            $email_destinatarios = ContratoDestinatario::with('destinatarios')
                ->where('contrato_id', $item->id)
                ->where('estado', 1)
                ->where('is_deleted',0)
                ->get();

            $destinatarios = [];
            
            foreach($email_destinatarios as $email_destinatario){

                array_push($destinatarios, $email_destinatario->destinatarios->email);
            }

            if ($item->pais_id == 2) { //Si es de Peru
                array_push($destinatarios, 'carmen.noel@gruporadical.com');
            }

            $details = [

                'title' => 'Notificación de finalización de operaciones (Contrato finalizado)',
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
                'plazo_finalizacion' => Carbon::now()->diffInDays(Carbon::parse($item->fecha_fin), false),

                //'tipo_tarea' => $item->tipo->nombre,

            ];


            Mail::to($email_cliente)
                ->cc($destinatarios)
                ->bcc('teamsoc@gruporadical.com', 'soporte@gruporadical.com')
                ->send(new FinContratoEmail($details));



            // SOLICITUD APERTURA DE TICKET
            //Mail::to('soporte@gruporadical.com')
            //->cc('paul.canchignia@gruporadical.com')
            //->send(new TicketFinalizacionContratoEmail($details));
            $item->alerta_fin_contrato == 1;
            $item->estado == 2; //finalizado
            //$item->cuenta_alertas=$item->cuenta_alertas+1;
            $item->save();
        }

        $this->info('Successfully sent daily quote to everyone.');
    }
}
