<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //$products = Product::all()->toArray();
        $contratos = Contrato::with('cliente', 'contrato', 'pais', 'area', 'mantenimiento', 'frecuencia')->get()->toArray();

        return array_reverse($contratos);
    }

    public function store(Request $request)
    {
        /* $product = new Product([
            'name' => $request->input('name'),
            'detail' => $request->input('detail')
        ]);
        $product->save(); */
        $mantenimientos = $request->input("selected");
        $mantenimientos = substr($mantenimientos, 0, -1);
        $arrayMantenimiento = explode(",", $mantenimientos);
        //dd($arrayMantenimiento);
        $contrato = new Contrato([
            'descripcion' => $request->input("descripcion"),
            'fecha_inicio' => $request->input("fecha_inicio"),
            'fecha_fin' => $request->input("fecha_fin"),
            'cliente_id' => $request->input('cliente'),
            'pais_id' => $request->input('pais'),
            'area_id' => $request->input('area'),
            'solucion' => $request->input('solucion'),
            'marca' => $request->input('marca'),
            'frecuencia' => $request->input('frecuencia'),
            //'mantenimientos' => $request['frecuencia'],
            'observacion' => $request->input("observacion"),
            //'fecha_creacion' => $hoy,
            'estado' => 0,
        ]);

        for ($i=0; $i < count($arrayMantenimiento); $i++) {
            Mantenimiento::create([
                'contrato_id' => $contrato->id,
                'fecha' => $arrayMantenimiento[$i],
                'estado' => 0
            ]);
        }


        return response()->json('Contrato created!');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Product updated!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product deleted!');
    }
}
