<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //     $clientes = Cliente::all();
        //    return view('cliente.index')->with('clientes', $clientes);
        $cond=['is_deleted' => 0];

        $clientes = Cliente::with('tipo_identificacion')->where($cond)->orderBy('nombre_comercial')->get()->toArray();
        return $clientes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $client = Cliente::create($request->all());
        // $clientes = Cliente::all();
        // return view('cliente.index')->with('clientes', $clientes);

        $client = new Cliente([
            'tipo_identificacion' => $request->input('tipo_identificacion'),
            'tipo_empresa' => $request->input('tipo_empresa'),
            'dni' => $request->input('dni'),
            'razon_social' => $request->input('razon_social'),
            'nombre_comercial' => $request->input('nombre_comercial'),
            'correo' => $request->input('correo'),
            'telefono' => $request->input('telefono'),
            'direccion' => $request->input('direccion'),

        ]);
        $client->save();

        return response()->json('Client created!');

    }

    public function show($id)
    {
        $client = Cliente::with('tipo_identificacion')->find($id);
        return response()->json($client);
    }

    public function update($id, Request $request)
    {
        $client = Cliente::find($id);
        $client->update($request->all());

        return response()->json('Client updated!');
    }

    public function destroy($id)
    {
        $client = Cliente::find($id);
        //$client->delete();
        $client->is_deleted=1;
        $client->save();

        return response()->json('Client deleted!');
    }
}
