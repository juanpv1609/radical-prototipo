<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\NotificacionSLA;
use Illuminate\Support\Facades\Mail;
use App\Providers\EmailSLAServiceProvider;

class SendAlertSLAAlto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alertSLAalto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the alert is sent when a ticket is created with a high priority';

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


        $days = [3, 5, 7]; //* Días de consulta a la API

        $priority = 'Alta';

        $status = 'New';

        $emailSLAService = new EmailSLAServiceProvider($priority, $status);

        $incidentesData = $emailSLAService->mergeIncidentsCategories(
            $emailSLAService->getIncidentsFilterByDate($days),
            $emailSLAService->addMailToCategories()
        );

        foreach ($incidentesData as $item) {
            // Dividir la cadena de destinatarios en un array
            $destinatarios = explode(',', $item['destinatario']);
            $destinatariosCC = explode(',', $item['cc']);

            // Iterar sobre los destinatarios y enviar el correo a cada uno
            foreach ($destinatarios as $destinatario) {
                $details = [
                    'title' => 'Notificación de SLA - Ticket abierto (Prioridad'. $priority .')',
                    'alerta' => $priority,
                    'body' => 'Estimad@ el software RGSDM (Radical Gestión SDM) ha generado la siguiente alerta: ',
                    'code' => $item['code'],
                    'status' => $item['status'],
                    'titleIncident' => $item['title'],
                    'description' => $item['description'],
                    'typeDate' => 'Modificación',
                    'date' => $item['dateLastModified'],
                    'message' => $item['message'],
                    'category' => $item['categoryName'],
                    'type' => $item['incidentType'],
                ];

                // Enviar el correo al destinatario actual
                Mail::to(trim($destinatario))
                ->cc($destinatariosCC)
                ->send(new NotificacionSLA($details));

            }
        }


        $this->info('Successfully sent daily quote to everyone.');
    }
}
