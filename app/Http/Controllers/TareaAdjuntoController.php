<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TareaAdjunto;

class TareaAdjuntoController extends Controller
{
    public function show($id)
    {
        $tarea_adjunto = TareaAdjunto::find($id);
        return response()->json($tarea_adjunto);
    }
}
