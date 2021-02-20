<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function printTareas($inicial,$final){
        $tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
            ->whereBetween('fecha',[$inicial,$final])
            ->get();
            $pdf = PDF::loadView('pdf.reporteTareas');
            return $pdf->download('reporteTareas.pdf');
    }
}
