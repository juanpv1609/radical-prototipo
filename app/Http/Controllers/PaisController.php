<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = Pais::all()->toArray();

        return ($paises);

    }
    public function store(Request $request)
    {
        $pais = new Pais([
            'nombre' => $request->input('nombre'),
            'abreviatura' => $request->input('abreviatura'),
            'estado' => 1
        ]);
        $pais->save();

        return response()->json('pais created!');
    }


    public function show($id)
    {
        $pais = Pais::find($id);
        return response()->json($pais);
    }

    public function update($id, Request $request)
    {
        $pais = Pais::find($id);
        $pais->update($request->all());

        return response()->json('pais updated!');
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);
        $pais->delete();

        return response()->json('pais deleted!');
    }
}

