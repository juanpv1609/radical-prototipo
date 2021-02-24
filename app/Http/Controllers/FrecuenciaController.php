<?php

namespace App\Http\Controllers;

use App\Models\Frecuencia;
use Illuminate\Http\Request;

class FrecuenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frecuencias = Frecuencia::where('estado',1)->get()->toArray();

        return ($frecuencias);
    }

    public function indexAll()
    {
        $frecuencias = Frecuencia::all()->toArray();

        return ($frecuencias);
    }

    public function store(Request $request)
    {
        $frecuencia = new Frecuencia([
            'descripcion' => $request->input('descripcion'),
            'alerta' => $request->input('alerta'),
            'estado' => 1
        ]);
        $frecuencia->save();

        return response()->json('frecuencia created!');
    }


    public function show($id)
    {
        $frecuencia = Frecuencia::find($id);
        return response()->json($frecuencia);
    }

    public function update($id, Request $request)
    {
        $frecuencia = Frecuencia::find($id);
        $frecuencia->update($request->all());

        return response()->json('frecuencia updated!');
    }

    public function destroy($id)
    {
        $frecuencia = Frecuencia::find($id);
        $frecuencia->delete();

        return response()->json('frecuencia deleted!');
    }
}
