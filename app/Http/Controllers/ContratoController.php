<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Contrato;
use Illuminate\Http\Request;
use App\Http\Controllers\SendMailController;

class ContratoController extends Controller
{
    public function index()
    {
        //$products = Product::all()->toArray();
        $contratos = Contrato::with('cliente', 'pais', 'area', 'tarea')->get()->toArray();

        return $contratos;
    }

    public function store(Request $request)
    {


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
            //'frecuencia' => $request->input('frecuencia'),
            'correos' => implode(",", $arrayCorreos),
            //'mantenimientos' => $request['frecuencia'],
            'observacion' => $request->input("observaciones"),
            //'fecha_creacion' => $hoy,
            'estado' => 0,
        ]);
        $contrato->save();
        // $contratoObject = new SendMailController();
        // $contratoObject->sendMailsClient($contrato->id);

        return response()->json('Contrato created!');
    }

    public function show($id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'tarea')->find($id);
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
