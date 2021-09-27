<?php

namespace App\Http\Controllers;

use App\Models\NivelEstudio;
use Illuminate\Http\Request;

class NivelEstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nivel_estudio = NivelEstudio::all()->toArray();

        return ($nivel_estudio);
    }
    public function listarNiveles()
    {
        $arr = [
            'estado' => 1,
            'is_deleted' => 0,
        ];
        $nivel_estudio = NivelEstudio::where($arr)->orderBy('descripcion')->get();
        return $nivel_estudio;
    }


    public function store(Request $request)
    {
        $nivel_estudio = new NivelEstudio([
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);
        $nivel_estudio->save();

        return response()->json('nivel_estudio created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nivel_estudio = NivelEstudio::find($id);
        return response()->json($nivel_estudio);
    }

    public function update(Request $request, $id)
    {
        $nivel_estudio = NivelEstudio::find($id);
        $nivel_estudio->update($request->all());

        return response()->json('nivel_estudio updated!');
    }

    public function destroy($id)
    {
        $nivel_estudio = NivelEstudio::find($id);
        //$user->delete();
        $nivel_estudio->is_deleted=1;
        $nivel_estudio->save();
        return response()->json('nivel_estudio deleted!');
    }
}
