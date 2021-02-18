<?php

namespace App\Http\Controllers;

use App\Models\TipoTarea;
use App\Models\EstadoTarea;
use Illuminate\Http\Request;
use App\Models\TipoIdentificacion;

class ConfigController extends Controller
{

    public function identificacion()
    {
        $tipo_identificacion = TipoIdentificacion::all()->toArray();

        return $tipo_identificacion;
    }
    public function estadoTareas()
    {
        $estado = EstadoTarea::all()->toArray();

        return $estado;
    }
    public function tipoTareas()
    {
        $tipo_tarea = TipoTarea::where('is_deleted',0)->get()->toArray();

        return $tipo_tarea;
    }

}
