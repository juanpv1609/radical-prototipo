<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Tareas;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use App\Models\Certificaciones;
use App\Models\Persona;
use App\Models\PersonaEstudio;

class ReportesController extends Controller
{
    public function reporteContratosPDF()
    {
        $hoy = date("Y-m-d");
        $total_terminados = 0;
        $total_iniciados = 0;
        $contratos = Contrato::with('cliente', 'pais', 'area', 'tarea', 'estado_contrato')->get();
        //dd($contratos);
        foreach ($contratos as $item) {
            if ($item->estado == 1)
                $total_iniciados++;
            else
                $total_terminados++;
        }
        $contratos->total_iniciados = $total_iniciados;
        $contratos->total_terminados = $total_terminados;
        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.contratos', compact('contratos'));

        return $pdf->download('reporteContratos_' . $hoy . '.pdf');
    }

    public function reporteContratosCSV()
    {
        $hoy = date("Y-m-d");
        $total_terminados = 0;
        $total_iniciados = 0;
        $contratos = Contrato::with('cliente', 'pais', 'area', 'tarea', 'estado_contrato')->get();
        //dd($contratos);
        foreach ($contratos as $item) {
            if ($item->estado == 1)
                $total_iniciados++;
            else
                $total_terminados++;
        }

        $csvData = fopen('php://temp', 'w');

        fputcsv($csvData, ['CLIENTE', 'DESCRIPCION', 'FECHA INICIO', 'FECHA FIN', 'AREA', 'ESTADO']);

        foreach ($contratos as $item){

            $estado = $item->estado == 1 ? "Iniciado" : "Terminado";

            fputcsv($csvData, [
                $item->cliente->razon_social,
                $item->observacion,
                $item->fecha_inicio,
                $item->fecha_fin,
                $item->area->nombre,
                $estado
            ]);
        }

        rewind($csvData);

        $csvContent = stream_get_contents($csvData);

        fclose($csvData);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporteContratos_'. $hoy . '.csv"',
        ];

        return response($csvContent, 200, $headers);
    }

    public function reporteTareasPDF($inicial, $final)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario', 'area')
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => auth()->user()->id
            ];
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario', 'area')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }
        $tareas->fecha_inicial = $inicial;
        $tareas->fecha_final = $final;
        $tareas->tareas_pendientes = $tareas_pendientes;
        $tareas->tareas_terminadas = $tareas_terminadas;

        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.tareas', compact('tareas'));
        return $pdf->download('reporteTareas_' . $inicial . '-' . $final . '.pdf');
    }
    public function reporteTareasCSV($inicial, $final)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario', 'area')
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => auth()->user()->id
            ];
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario', 'area')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }


        $csvData = fopen('php://temp', 'w');

        fputcsv($csvData, ['FECHA', 'RESPONSABLE', 'CLIENTE', 'AREA', 'ENTREGABLE', 'ESTADO']);

        foreach ($tareas as $item){
            fputcsv($csvData, [
                $item->fecha,
                $item->usuario->name,
                $item->contrato->cliente->nombre_comercial,
                $item->tipo->nombre,
                $item->descripcion,
                $item->estado_tarea->descripcion
            ]);
        }

        rewind($csvData);

        $csvContent = stream_get_contents($csvData);

        fclose($csvData);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporteTareas_' . $inicial . '-' . $final . '.csv"',
        ];

        return response($csvContent, 200, $headers);
    }
    public function reporteTareasContratoPDF($inicial, $final, $contrato_id)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where('contrato_id', $contrato_id)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => auth()->user()->id,
                'contrato_id' => $contrato_id
            ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }
        $tareas->fecha_inicial      =   $inicial;
        $tareas->fecha_final        =   $final;
        $tareas->tareas_pendientes  =   $tareas_pendientes;
        $tareas->tareas_terminadas  =   $tareas_terminadas;
        $contrato = Contrato::with('cliente')->find($contrato_id);
        $tareas->contrato_nombre            =   $contrato->descripcion;
        $tareas->contrato_descripcion       =   $contrato->observacion;
        $tareas->cliente_nombre_comercial   =   $contrato->cliente->nombre_comercial;

        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.tareas_contrato', compact('tareas'));
        return $pdf->download('reporteTareas_' . $inicial . '-' . $final . '.pdf');
    }

    public function reporteTareasContratoCSV($inicial, $final, $contrato_id)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where('contrato_id', $contrato_id)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => auth()->user()->id,
                'contrato_id' => $contrato_id
            ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }

        $csvData = fopen('php://temp', 'w');

        fputcsv($csvData, ['FECHA', 'RESPONSABLE', 'ENTREGABLE','TICKET', 'ESTADO']);

        foreach ($tareas as $item){
            fputcsv($csvData, [
                $item->fecha,
                $item->usuario->name,
                strtoupper($item->descripcion),
                $item->ticket,
                strtoupper($item->estado_tarea->descripcion)
            ]);
        }

        rewind($csvData);

        $csvContent = stream_get_contents($csvData);

        fclose($csvData);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporteTareasPorContrato_' . $inicial . '-' . $final . '.csv"',
        ];

        return response($csvContent, 200, $headers);

    }

    public function reporteTareasUsuarioPDF($inicial, $final, $usuario_id)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where('responsable', $usuario_id)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => $usuario_id
            ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }
        $tareas->fecha_inicial      =   $inicial;
        $tareas->fecha_final        =   $final;
        $tareas->tareas_pendientes  =   $tareas_pendientes;
        $tareas->tareas_terminadas  =   $tareas_terminadas;
        $usuario = User::find($usuario_id);
        $tareas->nombre_responsable            =   $usuario->name;

        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.tareas_usuario', compact('tareas'));
        return $pdf->download('reporteTareas_' . $inicial . '-' . $final . '.pdf');
    }

    public function reporteTareasUsuarioCSV($inicial, $final, $usuario_id)
    {
        $tareas_pendientes = 0;
        $tareas_terminadas = 0;

        if (auth()->user()->role == 2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where('responsable', $usuario_id)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        } else {
            $cond = [
                'responsable' => $usuario_id
            ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                ->where($cond)
                ->whereBetween('fecha', [$inicial, $final])
                ->orderBy('fecha')
                ->get();
        }

        foreach ($tareas as $item) {
            if ($item->estado_tarea->id == 1) { //pendientes
                $tareas_pendientes++;
            } else if ($item->estado_tarea->id == 2) { //terminadas
                $tareas_terminadas++;
            }
        }

        $csvData = fopen('php://temp', 'w');

        fputcsv($csvData, ['FECHA', 'TAREA', 'ENTREGABLE', 'ESTADO']);

        foreach ($tareas as $item){
            fputcsv($csvData, [
                $item->fecha,
                $item->tipo->nombre,
                $item->descripcion,
                strtoupper($item->estado_tarea->descripcion)
            ]);
        }

        rewind($csvData);

        $csvContent = stream_get_contents($csvData);

        fclose($csvData);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporteTareasPorUsuario_' . $inicial . '-' . $final . '.csv"',
        ];

        return response($csvContent, 200, $headers);

    }

    public function reporteCertificacionesPDF($certificaciones)
    {
        $arrayCertificaciones = explode(",", $certificaciones);
        $data = Certificaciones::whereIn('id', $arrayCertificaciones)->get();
        //$data = PersonaEstudio::with('pais','persona','nivelEstudio','estadoEstudio','certificaciones')->whereIn('certificado',$certificaciones)->get();

        $dataCertificaciones = [];
        $total_personas = 0;
        foreach ($data as $item) {
            $personaEstudio = PersonaEstudio::with('pais', 'persona', 'nivelEstudio', 'estadoEstudio', 'certificaciones')
                ->where('certificado', $item->id)->get();
            //$dataCertificaciones['certificacion'] = $data[$i]->solucion;
            //$auxPerson['certificacion'] = $data[$i]->solucion;
            $auxCertificaciones = [];
            $personas = [];
            foreach ($personaEstudio as $person) {
                $auxPerson = array(
                    "nombre" => $person->persona->nombre . ' ' . $person->persona->apellido,
                    "pais" => $person->pais->nombre,
                    "pais_abreviatura" => $person->pais->abreviatura,
                    "estado" => $person->estadoEstudio->descripcion,
                    "estado_color" => $person->estadoEstudio->color,
                );
                //$auxPerson['nombre'] = $person->persona->nombre.' '.$person->persona->apellido;
                array_push($personas, $auxPerson);
            }
            $total_personas += count($personaEstudio);
            $auxCertificaciones = array(
                'certificacion' => $item->solucion,
                'total' => count($personaEstudio),
                'total_personas' => $total_personas,
                'personas' => $personas
            );
            array_push($dataCertificaciones, $auxCertificaciones);
            //array_push($dataCertificaciones['certificacion'], $personas);

            //$dataCertificaciones['certificacion']= $personas;
        }
        //$dataCertificaciones['total_personas'] = $total_personas;
        //$dataCertificaciones = $aux;
        //dd($dataCertificaciones);



        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.certificaciones', compact('dataCertificaciones'));
        return $pdf->download('reporteCertificaciones.pdf');
    }
    public function reportePersonaPDF($id)
    {
        $persona = Persona::with('pais', 'nacionalidad')->findOrFail($id);
        $personaEstudio = PersonaEstudio::with('pais', 'persona', 'nivelEstudio', 'estadoEstudio', 'certificaciones')
            ->where('persona_id', $persona->id)->get();
        $estudios = [];
        $certificaciones = [];
        $auxPersona = [];
        $dataPersona = [];
        foreach ($personaEstudio as $item) {
            $auxEstudios = array(
                "descripcion" => $item->descripcion,
                "institucion" => $item->institucion,
                "titulo" => $item->titulo,
                "nivel" => $item->nivelEstudio->descripcion,
                "inicio" => $item->fecha_inicio,
                "fin" => $item->fecha_fin,
                "certificado" => $item->certificado,
                "estado" => $item->estadoEstudio->descripcion,
                "estado_color" => $item->estadoEstudio->color,
            );
            if ($item->certificado !== null) {
                # code...
                $auxCertificaciones = array(
                    "solucion" => $item->certificaciones->solucion,
                    "descripcion" => $item->descripcion,
                    "institucion" => $item->institucion,
                    "link" => $item->documentos,
                );
                array_push($certificaciones, $auxCertificaciones);
            }
            array_push($estudios, $auxEstudios);
        }
        //dd($certificaciones);

        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.persona', compact(['persona', 'estudios', 'certificaciones']));
        return $pdf->download('reporte_' . $persona->nombre . ' ' . $persona->apellido . '.pdf');
    }
}
