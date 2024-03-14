<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class EmailSLAServiceProvider
{
    // ! Credenciales de acceso a la API ( Escalar a base de datos )
    protected const PANET_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJwYW5ldC5hZG1pbiIsIm92ciI6ImZhbHNlIiwiYXV0IjoiMCIsIm5iZiI6MTY4NjM0NDcwNiwiZXhwIjoxNzE3ODgwNzA2LCJpYXQiOjE2ODYzNDQ3MDYsImlzcyI6InByb2FjdGl2YW5ldCIsImF1ZCI6ImFwaSJ9.8PHCIFVfIIme_twFYH9WHZB0T8-7KymKgXyhTC6OZIw';
    protected const API_PANET = 'https://soporte.gruporadical.com/proactivanet/api/';

    protected $namePriority, $statusIncident;

    // ! destinatarios por categoría, escalar a la base de datos
    public function __construct($namePriority, $status)
    {
        $this->namePriority = $namePriority;
        $this->statusIncident = $status;
    }

    //! Obtener todas las categorías solo de CNT defensiva.
    public function getCategories()
    {
        $url = self::API_PANET . 'Categories?PadCategories_id=b9c8f12c-f4ef-44e1-9970-ddfa86b5b3da&$fields=Name';

        $response = Http::withHeaders([
            'Authorization' => self::PANET_KEY,
        ])->withOptions(['verify' => false])->accept('application/json')->get($url);

        $categories = json_decode($response->body(), true);

        return array_map(function ($category) {
            return [
                'id' => $category['Id'],
                'categoryName' => $category['Name'],
                'destinatario' => '',
                'cc' => '',
            ];
        }, $categories);
    }

    public function getTypesIncidents()
    {
        $url = self::API_PANET . 'Types?$limit=10&$fields=Name';

        $response = Http::withHeaders([
            'Authorization' => self::PANET_KEY,
        ])->withOptions(['verify' => false])->accept('application/json')->get($url);

        $typesIncidents = json_decode($response->body(), true);

        return array_map(function ($typesIncidents) {
            return [
                'id' => $typesIncidents['Id'],
                'typeName' => $typesIncidents['Name'],
            ];
        }, $typesIncidents);
    }



    //* Funcion que devuelve el id de la prioridad seleccionada
    public function getPriority($namePriority)
    {
        $url = self::API_PANET . 'Priorities?Name=' . $namePriority . '&$fields=none';

        $response = Http::withHeaders([
            'Authorization' => self::PANET_KEY,
        ])->withOptions(['verify' => false])->accept('application/json')->get($url);

        if ($response->successful()) {
            // Decodificar la respuesta JSON
            $priorityData = json_decode($response->body(), true);

            // Verificar si se encontró una prioridad
            if (!empty($priorityData) && isset($priorityData[0]['Id'])) {
                // Devolver el valor del campo "Id" como cadena
                return $priorityData[0]['Id'];
            } else {
                return null; // Prioridad no encontrada
            }
        } else {
            return null; // Hubo un error en la solicitud
        }
    }

    public function getIncidentsByDateStatusANDPriority($searchDate)
    {

        $idPriority = $this->getPriority($this->namePriority);

        $url = self::API_PANET . 'Incidents?Status=' . $this->statusIncident . $searchDate . '&PadCustomers_id=09078f3d-e3e9-44f6-a50d-d1c78e5d1fa4&PadPriorities_id=' . $idPriority . '&PadTypes_id=f5afde2e-8eb2-4167-81c0-0af8466d2c4e%2C4fbc5a37-25e1-4269-ac93-c4667fc4dfd9&$fields=Code,CreationDate,DateLastModified,Description,PadTypes_id,PadCategories_id,Status,Title';

        $response = Http::withHeaders([
            'Authorization' => self::PANET_KEY,
        ])->withOptions(['verify' => false])->accept('application/json')->get($url);

        $incidents = json_decode($response->body(), true);

        return $incidents;
    }




    public function getIncidentsFilterByDate(array $days)
    {
        $filteredIncidents = [];

        foreach ($days as $day) {
            $Date = Carbon::now('America/Guayaquil')->subDays($day)->format('Y-m-d');

            if ($this->statusIncident == 'New') {
                $searchDate = '&CreationDate=' . $Date;
                $plazo = 'El ticket se cierra en: ' . max($days) - $day . 'día(s)';
            } else {
                $searchDate = '&DateLastModified=' . $Date;
                $plazo = 'El informe debe ser enviado en: ' . $this->calculateRemainingTimeCritica();
            }


            $incidents = $this->getIncidentsByDateStatusANDPriority($searchDate);

            if ($incidents === 'No data found on Incidents with GET') {
                continue;
            }
            $filteredIncidents = $this->transforIncidentsJsonOfArray($incidents, $plazo);
        }

        return array_filter($filteredIncidents);
    }

    public function getIncidentsFilterByDate2(array $days)
    {
        $filteredIncidents = [];

        foreach ($days as $day) {
            $Date = Carbon::now('America/Guayaquil')->subDays($day)->format('Y-m-d');

            $searchDate = '&DateLastModified=' . $Date;
            $plazo = 'El informe debe ser enviado en: ' . $this->calculateRemainingTimeCritica2();

            $incidents = $this->getIncidentsByDateStatusANDPriority($searchDate);

            if ($incidents === 'No data found on Incidents with GET') {
                continue;
            }
            $filteredIncidents = $this->transforIncidentsJsonOfArray($incidents, $plazo);
        }

        return array_filter($filteredIncidents);
    }

    public function calculateRemainingTimeCritica()
    {
        $now = Carbon::now('America/Guayaquil');
        $targetTime = Carbon::parse('23:59:59', 'America/Guayaquil');
        $diff = $targetTime->diff($now);
        return $diff->format('%h horas %i minutos %s segundos');
    }

    public function calculateRemainingTimeCritica2()
    {
        $now = Carbon::now('America/Guayaquil');
        $targetTime = Carbon::parse('23:59:59', 'America/Guayaquil');
        $diff = $targetTime->diff($now);
        return $diff->format(1 . 'día %h horas %i minutos %s segundos');
    }



    public function transforIncidentsJsonOfArray($incidents, $plazo)
    {

        $filteredIncidents = [];

        $filteredIncidents = array_merge($filteredIncidents, array_map(function ($incident) use ($plazo) {
            return [
                'id' => $incident['Id'],
                'code' => $incident['Code'],
                'creationDate' => $incident['CreationDate'],
                'dateLastModified' => $incident['DateLastModified'],
                'description' => $incident['Description'],
                'padTypes_id' => $incident['PadTypes_id'],
                'padCategories_id' => $incident['PadCategories_id'],
                'status' => $incident['Status'],
                'title' => $incident['Title'],
                'message' => $plazo,
                'destinatario' => '',
                'cc'=>'',
                'categoryName' => '',
                'incidentType' => '',
            ];
        }, $incidents));

        return $filteredIncidents;
    }


    public function addMailToCategories()
    {
        $categories = $this->getCategories();

        // ! destinatarios por categoría, escalar a la base de datos
        $destinatarios = [
            'SIEM' => 'juan.perugachi@gruporadical.com',
            'Análisis de Vulnerabilidades Web' => 'lenin.cortes@gruporadical.com',
            'Web Application Firewall' => 'richard.teran@gruporadical.com',
            'Firewall' => 'washington.cardenas@gruporadical.com',
            'CIFRADO' => 'christian.molina@gruporadical.com',
            'Pentesting' => 'lenin.cortes@gruporadical.com',
            'Análisis de Vulnerabilidades' => 'lenin.cortes@gruporadical.com',
        ];

        $cc = [
            'SIEM' => 'brenda.perez@gruporadical.com,maylee.pineda@gruporadical.com,paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com',
            'Análisis de Vulnerabilidades Web' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,lenin.cortes@gruporadical.com,ciberseguridad@gruporadical.com',
            'Web Application Firewall' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,lenin.cortes@gruporadical.com,ciberseguridad@gruporadical.com',
            'Firewall' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,lenin.cortes@gruporadical.com,ciberseguridad@gruporadical.com',
            'CIFRADO' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,lenin.cortes@gruporadical.com,ciberseguridad@gruporadical.com',
            'Pentesting' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,ciberseguridad@gruporadical.com',
            'Análisis de Vulnerabilidades' => 'paul.canchignia@gruporadical.com,diana.arevalo@gruporadical.com,ciberseguridad@gruporadical.com',
        ];

        foreach ($categories as &$category) {
            if (isset($destinatarios[$category['categoryName']])) {
                $category['destinatario'] = $destinatarios[$category['categoryName']];
                $category['cc'] = $cc[$category['categoryName']];
            } else {
                $category['destinatario'] = '';
                $category['cc']='';
            }
        }

        return array_filter($categories);
    }

    public function mergeIncidentsCategories($incidentes, $categories)
    {
        $mergedIncidents = [];
        foreach ($incidentes as $incident) {
            foreach ($categories as $category) {
                if ($incident['padCategories_id'] == $category['id']) {
                    $incident['categoryName'] = $category['categoryName'];
                    $incident['destinatario'] = $category['destinatario'];
                    $incident['cc'] = $category['cc'];
                    $mergedIncidents[] = $incident;
                }
            }
        }
        return $this->mergeIncidentsTypes($mergedIncidents);
    }

    public function mergeIncidentsTypes($incidentes)
    {

        $types = $this->getTypesIncidents();

        $mergedIncidents = [];
        foreach ($incidentes as $incident) {
            foreach ($types as $type) {
                if ($incident['padTypes_id'] == $type['id']) {
                    $incident['incidentType'] = $type['typeName'];
                    $mergedIncidents[] = $incident;
                }
            }
        }
        return $mergedIncidents;
    }



    // * Para los tickets abiertos prioridad Critica
    public function verifyDay() {
        $today = Carbon::now('America/Guayaquil')->dayOfWeek;

        $days = [
            Carbon::MONDAY => [1, 2, 3],
            Carbon::TUESDAY => [1],
            Carbon::WEDNESDAY => [1],
            Carbon::THURSDAY => [1],
            Carbon::FRIDAY => [1],
            Carbon::SATURDAY => [],
            Carbon::SUNDAY => [],
        ];

        return $days[$today];
    }
    // * Resto de prioridades.
    public function verifyDay2() {
        $days = [
            Carbon::MONDAY => [4],
            Carbon::TUESDAY => [4],
            Carbon::WEDNESDAY => [2, 3, 4],
            Carbon::THURSDAY => [2],
            Carbon::FRIDAY => [2],
            Carbon::SATURDAY => [2],
            Carbon::SUNDAY => [],
        ];

        $today = Carbon::now('America/Guayaquil')->dayOfWeek;

        return $days[$today];
    }
}
