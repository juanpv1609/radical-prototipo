<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonaMerito;

class PersonaMeritoController extends Controller
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
        $meritos = PersonaMerito::with('persona','autoridad')->where($arr)->get();
        return $meritos;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $metito = new PersonaMerito([
            'persona_id'                => $request->input('persona_id'),
            'fecha'            => $request->input('fecha'),
            'autoridad_id'          => $request->input('autoridad_id'),
            'is_merito'             => $request->input('is_merito'),
            'descripcion'             => $request->input('descripcion'),
            'is_deleted'           => 0,
        ]);
        $metito->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $arr = [
            'is_deleted' => 0,
            'persona_id' => $id,
        ];


         $meritos = PersonaMerito::with('persona', 'autoridad')->where($arr)->get();
        return $meritos;

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
        $merito = PersonaMerito::find($id);
        $merito->persona_id           = $request->input('persona_id');
        $merito->fecha                = $request->input('fecha');
        $merito->autoridad_id         = $request->input('autoridad_id');
        $merito->is_merito             = $request->input('is_merito');
        $merito->descripcion          = $request->input('descripcion');

        $persona->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merito = PersonaMerito::find($id);
        $merito->is_deleted=1;
        $merito->save();

    }
}
