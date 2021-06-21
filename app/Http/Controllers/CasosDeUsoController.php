<?php

namespace App\Http\Controllers;

use App\Models\CasosDeUso;
use Illuminate\Http\Request;

class CasosDeUsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cond = [
            'is_deleted' => 0
        ];
        $casos = CasosDeUso::where($cond)->get()->toArray();
        //dd($casos);
        return $casos;
    }


    public function store(Request $request)
    {
        $arrayFuentes = $request->input('fuentes');
        $caso = new CasosDeUso([
            'nombre' => $request->input("nombre"),
            'descripcion' => $request->input("descripcion"),
            'tipo' => $request->input('tipo'),
            'fuentes' =>  implode(",", $arrayFuentes),
            'estado' => $request->input('estado') ? 1 : 0,
        ]);
        $caso->save();
        // $contratoObject = new SendMailController();
        // $contratoObject->sendMailsClient($contrato->id);

        return response()->json('Caso created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $arrayFuentes = $request->input('fuentes');
        $caso = CasosDeUso::find($id);
        $caso->nombre = $request->input("nombre");
        $caso->descripcion = $request->input("descripcion");
        $caso->tipo = $request->input("tipo");
        $caso->fuentes = implode(",", $arrayFuentes);
        $caso->estado = $request->input("estado");
        $caso->save();
        return response()->json('Caso updated!');
    }

    public function destroy($id)
    {
        $caso = CasosDeUso::find($id);
        //$caso->delete();
        $caso->is_deleted = 1;
        $caso->save();

        return response()->json('Caso deleted!');
    }
}
