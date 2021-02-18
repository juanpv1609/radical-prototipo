<?php

namespace App\Http\Controllers;

use App\Models\TipoTarea;
use Illuminate\Http\Request;

class TipoTareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_tareas = TipoTarea::where('is_deleted',0)->get()->toArray();

        return $tipo_tareas;
    }

    public function store(Request $request)
    {
        $tipo_tarea = new TipoTarea([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);
        $tipo_tarea->save();

        return response()->json('tipo_tarea created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipo_tarea = TipoTarea::find($id);
        return response()->json($tipo_tarea);
    }


    public function update(Request $request, $id)
    {
        $tipo_tarea = TipoTarea::find($id);
        $tipo_tarea->update($request->all());

        return response()->json('tipo_tarea updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_tarea = TipoTarea::find($id);
        //$client->delete();
        $tipo_tarea->is_deleted=1;
        $tipo_tarea->save();

        return response()->json('tipo_tarea deleted!');
    }
}
