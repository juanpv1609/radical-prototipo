<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Tareas;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReportesController extends Controller
{
    public function reporteTareas($inicial, $final)
    {
        $tareas_pendientes=0;
        $tareas_terminadas=0;

        if (auth()->user()->role==2) { //administrador
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->whereBetween('fecha', [$inicial,$final])
            ->orderBy('fecha')
            ->get();
        } else {
            $cond=[
                        'responsable' => auth()->user()->id
                    ];
            $tareas = Tareas::with('contrato.cliente', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                                ->where($cond)
                                ->whereBetween('fecha', [$inicial,$final])
                                ->orderBy('fecha')
                                ->get();
        }

        foreach ($tareas as $item ) {
            if ($item->estado_tarea->id==1) { //pendientes
                $tareas_pendientes++;

            }else if ($item->estado_tarea->id==2) { //terminadas
                $tareas_terminadas++;
            }

        }
        $tareas->fecha_inicial=$inicial;
        $tareas->fecha_final=$final;
        $tareas->tareas_pendientes=$tareas_pendientes;
        $tareas->tareas_terminadas=$tareas_terminadas;

        $pdf = App::make('dompdf.wrapper');

        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('pdf.tareas', compact('tareas'));
        return $pdf->download('reporteTareas_'.$inicial.'-'.$final.'.pdf');
    }
    public function reporteTareasContrato($inicial, $final, $contrato_id)
    {
        $tareas_pendientes=0;
        $tareas_terminadas=0;

        if (auth()->user()->role==2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->where('contrato_id',$contrato_id)
            ->whereBetween('fecha', [$inicial,$final])
            ->orderBy('fecha')
            ->get();
        } else {
            $cond=[
                        'responsable' => auth()->user()->id,
                        'contrato_id' => $contrato_id
                    ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                                ->where($cond)
                                ->whereBetween('fecha', [$inicial,$final])
                                ->orderBy('fecha')
                                ->get();
        }

        foreach ($tareas as $item ) {
            if ($item->estado_tarea->id==1) { //pendientes
                $tareas_pendientes++;

            }else if ($item->estado_tarea->id==2) { //terminadas
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
        return $pdf->download('reporteTareas_'.$inicial.'-'.$final.'.pdf');
    }
    public function reporteTareasUsuario($inicial, $final, $usuario_id)
    {
        $tareas_pendientes=0;
        $tareas_terminadas=0;

        if (auth()->user()->role==2) { //administrador
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
            ->where('responsable',$usuario_id)
            ->whereBetween('fecha', [$inicial,$final])
            ->orderBy('fecha')
            ->get();
        } else {
            $cond=[
                        'responsable' => $usuario_id
                    ];
            $tareas = Tareas::with('contrato', 'frecuencias', 'estado_tarea', 'tipo', 'usuario')
                                ->where($cond)
                                ->whereBetween('fecha', [$inicial,$final])
                                ->orderBy('fecha')
                                ->get();
        }

        foreach ($tareas as $item ) {
            if ($item->estado_tarea->id==1) { //pendientes
                $tareas_pendientes++;

            }else if ($item->estado_tarea->id==2) { //terminadas
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
        return $pdf->download('reporteTareas_'.$inicial.'-'.$final.'.pdf');
    }
}
