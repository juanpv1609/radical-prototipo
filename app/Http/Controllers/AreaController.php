<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cond=['is_deleted' => 0];

        $areas = Area::where($cond)->get()->toArray();

        return $areas;



    }

    
    public function store(Request $request)
    {
        $area = new Area([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'estado' => 1
        ]);
        $area->save();

        return response()->json('Area created!');
    }


    public function show($id)
    {
        $area = Area::find($id);
        return response()->json($area);
    }

    public function update($id, Request $request)
    {
        $area = Area::find($id);
        $area->update($request->all());

        return response()->json('Area updated!');
    }

    public function destroy($id)
    {
        $area = Area::find($id);
        $area->is_deleted=1;
        $area->save();
        //$area->delete();

        return response()->json('Area deleted!');
    }
}
