<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
   public function index()
    {
        $marcas = Marca::where('is_deleted',0)->get()->toArray();

        return $marcas;
    }

    public function store(Request $request)
    {
        $marcas = new Marca([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
            'is_deleted' => 0,
        ]);
        $marcas->save();

        return response()->json('marcas created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marcas = Marca::find($id);
        return response()->json($marcas);
    }


    public function update(Request $request, $id)
    {
        $marcas = Marca::find($id);
        $marcas->update($request->all());

        return response()->json('marcas updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marcas = Marca::find($id);
        //$client->delete();
        $marcas->is_deleted=1;
        $marcas->save();

        return response()->json('marcas deleted!');
    }
}
