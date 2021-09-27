<?php

namespace App\Http\Controllers;

use App\Models\PerfilPuesto;
use Illuminate\Http\Request;

class PerfilPuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr = [
            'is_deleted' => 0,
        ];
        $perfiles = PerfilPuesto::with('area')->where($arr)->get();
        return $perfiles;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $perfil = new PerfilPuesto([
            'area_id'                => $request->input('area_id'),
            'descripcion'            => $request->input('descripcion'),
            'funciones'          => implode(",",$request->input('funciones')),
            'responsabilidades'             => implode(",",$request->input('responsabilidades')),
            'is_deleted'           => 0,
        ]);
        $perfil->save();

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $perfil = PerfilPuesto::find($id);
        $perfil->area_id                = $request->input('area_id');
        $perfil->descripcion            = $request->input('descripcion');
        $perfil->funciones              = implode(",",$request->input('funciones'));
        $perfil->responsabilidades      = implode(",",$request->input('responsabilidades'));
        $perfil->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perfil = PerfilPuesto::find($id);
        $perfil->is_deleted=1;
        $perfil->save();

    }
}
