<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\NotificacionSLA;
use Illuminate\Support\Facades\Mail;
use App\Providers\EmailSLAServiceProvider;

class SendAlertInformeSLAAlto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alertInformeSLAalto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $priority = 'Alta';
        $status = 'Closed';

        $emailSLAService = new EmailSLAServiceProvider($priority, $status);

        $emailSLAService = new EmailSLAServiceProvider($priority, $status);

        $days = $emailSLAService->verifyDay();
        $days2 = $emailSLAService->verifyDay2();

        $incidentesData = $emailSLAService->mergeIncidentsCategories(
            $emailSLAService->getIncidentsFilterByDate2($days),
            $emailSLAService->addMailToCategories()
        );

        $incidentesData2 = $emailSLAService->mergeIncidentsCategories(
            $emailSLAService->getIncidentsFilterByDate($days2),
            $emailSLAService->addMailToCategories()
        );

        $incidentesData = array_merge($incidentesData, $incidentesData2);

        foreach ($incidentesData as $item) {
            // Dividir la cadena de destinatarios en un array
            $destinatarios = explode(',', $item['destinatario']);

            // Iterar sobre los destinatarios y enviar el correo a cada uno
            foreach ($destinatarios as $destinatario) {
                $details = [
                    'title' => 'Notificación de SLA - Entrega del Informe Técnico (Prioridad ' . $priority . ')',
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
                Mail::to(trim($destinatario))->send(new NotificacionSLA($details));
            }
        }


        $this->info('Successfully sent daily quote to everyone.');
    }
}
