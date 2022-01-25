<?php

namespace App\Http\Controllers;

use App\Models\Modalidad;
use Illuminate\Http\Request;

class ModalidadController extends Controller
{
    public function index()
    {
        $modalidades = Modalidad::where('is_deleted',0)->get()->toArray();

        return $modalidades;
    }

    public function store(Request $request)
    {
        $modalidades = new Modalidad([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'horas' => $request->input('horas'),
            'dias' => $request->input('dias'),
            'estado' => $request->input('estado'),
            'is_deleted' => 0,
        ]);
        $modalidades->save();

        return response()->json('modalidades created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modalidades = Modalidad::find($id);
        return response()->json($modalidades);
    }


    public function update(Request $request, $id)
    {
        $modalidades = Modalidad::find($id);
        $modalidades->update($request->all());

        return response()->json('modalidades updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modalidades = Modalidad::find($id);
        //$client->delete();
        $modalidades->is_deleted=1;
        $modalidades->save();

        return response()->json('modalidades deleted!');
    }
}
