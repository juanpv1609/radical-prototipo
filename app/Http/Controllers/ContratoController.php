<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        //$products = Product::all()->toArray();
        $contratos = Contrato::with('cliente', 'pais', 'area', 'mantenimiento', 'frecuencias')->get()->toArray();

        return $contratos;
    }

    public function store(Request $request)
    {

        // $mantenimientos = $request->input("selected");
        // $mantenimientos = substr($mantenimientos, 0, -1);
        // $arrayMantenimiento = explode(",", $mantenimientos);
        //dd($request);
        $arrayMantenimientos = $request->input("mantenimientos");
        $arrayCorreos = $request->input("correos");

        $contrato = new Contrato([
            'descripcion' => $request->input("descripcion"),
            'fecha_inicio' => $request->input("fecha_inicio"),
            'fecha_fin' => $request->input("fecha_fin"),
            'cliente_id' => $request->input('cliente'),
            'pais_id' => $request->input('pais'),
            'area_id' => $request->input('area'),
            'solucion' => $request->input('solucion'),
            'marca' => $request->input('marca'),
            'frecuencia' => $request->input('frecuencia'),
            'correos' => implode(",", $arrayCorreos),
            //'mantenimientos' => $request['frecuencia'],
            'observacion' => $request->input("observaciones"),
            //'fecha_creacion' => $hoy,
            'estado' => 0,
        ]);
        $contrato->save();
        foreach ($arrayMantenimientos as $item) {
            Mantenimiento::create([
                'contrato_id' => $contrato->id,
                'fecha' => $item['fecha'],
                'alerta' => $item['alerta'],
                'observacion' => '',
                'estado' => 0
            ]);
        }
        /* for ($i=0; $i < count($arrayMantenimiento); $i++) {
            Mantenimiento::create([
                'contrato_id' => $contrato->id,
                'fecha' => $arrayMantenimientos[$i],
                'estado' => 0
            ]);
        } */


        return response()->json('Contrato created!');
    }

    public function show($id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'mantenimiento', 'frecuencias')->find($id);
        return response()->json($contrato);
    }

    public function update($id, Request $request)
    {
        $contrato = Contrato::find($id);
        $contrato->update($request->all());

        return response()->json('Product updated!');
    }

    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        $contrato->delete();

        return response()->json('Product deleted!');
    }
}
