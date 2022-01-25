<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\TipoTarea;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::with('area')->where('is_deleted',0)->get()->toArray();

        return $servicios;
    }

    public function store(Request $request)
    {
        $servicios = new Servicio([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'area_id' => $request->input('area_id'),
            'estado' => $request->input('estado'),
            'observaciones' => $request->input('observaciones'),
            'is_deleted' => 0,
        ]);
        $servicios->save();

        return response()->json('servicios created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicios = Servicio::find($id);
        return response()->json($servicios);
    }


    public function update(Request $request, $id)
    {
        $servicios = Servicio::find($id);
        $servicios->update($request->all());

        return response()->json('servicios updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicios = Servicio::find($id);
        //$client->delete();
        $servicios->is_deleted=1;
        $servicios->save();

        return response()->json('servicios deleted!');
    }
}
