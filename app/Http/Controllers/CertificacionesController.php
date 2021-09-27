<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificaciones;

class CertificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr = [
            //'estado' => 1,
            'is_deleted' => 0,
        ];
        $certificaciones = Certificaciones::where($arr)->get();
        return $certificaciones;
    }
    public function listarCertificaciones()
    {
        $arr = [
            'estado' => 1,
            'is_deleted' => 0,
        ];
        $certificaciones = Certificaciones::where($arr)->get();
        return $certificaciones;
    }

    public function store(Request $request)
    {
        $certificacion = new Certificaciones([
            'solucion' => $request->input('solucion'),
            'estado' => $request->input('estado'),
        ]);
        $certificacion->save();

        return $certificacion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $certificacion = Certificaciones::find($id);
        return response()->json($certificacion);
    }

    public function update(Request $request, $id)
    {
        $certificacion = Certificaciones::find($id);
        $certificacion->update($request->all());

        return response()->json('certificacion updated!');
    }

    public function destroy($id)
    {
        $certificacion = Certificaciones::find($id);
        //$user->delete();
        $certificacion->is_deleted=1;
        $certificacion->save();
        return response()->json('certificacion deleted!');
    }
}
