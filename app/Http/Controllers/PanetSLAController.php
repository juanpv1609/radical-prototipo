<?php

namespace App\Http\Controllers;

use App\Providers\EmailSLAServiceProvider;
use App\Mail\NotificacionSLA;
use Illuminate\Support\Facades\Mail;

class PanetSLAController extends Controller
{

    public function getSLANotification($priority)
    {

        $status = 'New';
        $emailSLAService = new EmailSLAServiceProvider($priority, $status);
        $days = $this->veryfyDateSearch($priority);
        $incidentesData = $emailSLAService->mergeIncidentsCategories(
            $emailSLAService->getIncidentsFilterByDate($days),
            $emailSLAService->addMailToCategories()
        );
        return $incidentesData;
    }

    public function getSLAInformeNotification($priority)
    {
        $status = 'Closed';
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
        return $incidentesData;
    }

    public function veryfyDateSearch($priority)
    {
        $days = [
            'Baja' => [10, 15, 20],
            'Media' => [7, 12, 14],
            'Alta' => [3, 5, 7],
            'Critica' => [3, 5, 7]
        ];

        return $days[$priority];
    }

    public function sendNotificationTicket($priority)
    {
        $incidents = $this->getSLANotification($priority);
        foreach ($incidents as $item) {
            // Dividir la cadena de destinatarios en un array
            $destinatarios = explode(',', $item['destinatario']);
            $destinatariosCC = explode(',', $item['cc']);

            // Iterar sobre los destinatarios y enviar el correo a cada uno
            foreach ($destinatarios as $destinatario) {
                $details = [
                    'title' => 'Notificación de SLA - Ticket abierto (Prioridad' . $priority . ')',
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
    }

    public function sendNotificationInforme($priority)
    {
        $incidents = $this->getSLAInformeNotification($priority);
        foreach ($incidents as $item) {
            // Dividir la cadena de destinatarios en un array
            $destinatarios = explode(',', $item['destinatario']);
            $destinatariosCC = explode(',', $item['cc']);

            // Iterar sobre los destinatarios y enviar el correo a cada uno
            foreach ($destinatarios as $destinatario) {
                $details = [
                    'title' => 'Notificación de SLA - Ticket abierto (Prioridad' . $priority . ')',
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
    }


}
