<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoIdentificacion;

class IdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_identificacion = TipoIdentificacion::all()->toArray();

        return $tipo_identificacion;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo_identificacion = new TipoIdentificacion([
            'nombre' => $request->input('nombre'),
            'estado' => 1
        ]);
        $tipo_identificacion->save();

        return response()->json('Area created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipo_identificacion = TipoIdentificacion::find($id);
        return response()->json($tipo_identificacion);
    }

    public function update($id, Request $request)
    {
        $tipo_identificacion = TipoIdentificacion::find($id);
        $tipo_identificacion->update($request->all());

        return response()->json('Area updated!');
    }

    public function destroy($id)
    {
        $tipo_identificacion = TipoIdentificacion::find($id);
        $tipo_identificacion->delete();

        return response()->json('Area deleted!');
    }
}
