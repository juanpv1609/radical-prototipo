<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Contrato;
use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Models\ContratoServicio;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SendMailController;

class ContratoController extends Controller
{
    public function index()
    {
        //$products = Product::all()->toArray();
        $contratos = Contrato::with('cliente', 'pais', 'area', 'tarea','estado_contrato','servicios')->get()->toArray();

        return $contratos;
    }

    public function store(Request $request)
    {


        $arrayCorreos = $request->input("correos");
        $arrayAdjuntos = $request->input("adjuntos");
        $arrayServicios = $request->input("servicios");

        $contrato = new Contrato([
            'descripcion' => $request->input("descripcion"),
            'fecha_inicio' => $request->input("fecha_inicio"),
            'fecha_fin' => $request->input("fecha_fin"),
            'cliente_id' => $request->input('cliente'),
            'pais_id' => $request->input('pais'),
            'area_id' => $request->input('area'),
            'solucion' => $request->input('solucion'),
            'marca' => $request->input('marca'),
            'correos' => implode(",", $arrayCorreos),
            'adjunto' => implode(",", $arrayAdjuntos),
            'observacion' => $request->input("observacion"),
            'estado' => 1,
        ]);
        $contrato->save();
        foreach ($arrayServicios as $item) {
            # code...
            $contrato_servicio = new ContratoServicio([
                'contrato_id' => $contrato->id,
                'servicio_id' => $item['id'],
                'estado' => 1,
                'is_deleted' => 0
            ]);
            $contrato_servicio->save();

        }
        // $contratoObject = new SendMailController();
        // $contratoObject->sendMailsClient($contrato->id);

        return response()->json('Contrato created!');
    }

    public function show($id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'tarea')->find($id);
        return response()->json($contrato);
    }

    public function update($id, Request $request)
    {
        $arrayCorreos = $request->input("correos");
        $arrayAdjuntos = $request->input("adjuntos");
        $arrayServicios = $request->input("servicios");

        $contrato = Contrato::find($id);
        // BORRAR ARCHIVOS ANTERIORES
        /* if ($contrato->adjunto!=='') {
            $arrayAdjuntosOld = explode(",", $contrato->adjunto); //convierte a array
            foreach ($arrayAdjuntosOld as $item) {
                if (Storage::disk('local')->exists($item)) {
                    Storage::delete($item);
                }
            }
        } */
        $arrayAdjuntosOld = explode(",", $contrato->adjunto);
        if ((count($arrayAdjuntos)>0) && (count($arrayAdjuntosOld)>0)) { // si mando al menos un adjunto y ya se tenian adjuntos
            foreach ($arrayAdjuntos as $new) {
                # code...
                array_push($arrayAdjuntosOld,$new);
            }
        }
        $arrayCorreosOld = explode(",", $contrato->correos);
        if ((isset($arrayCorreos)>0) && (count($arrayCorreosOld)>0)) { // si mando al menos un adjunto y ya se tenian Correos
            foreach ($arrayCorreos as $new) {
                # code...
                array_push($arrayCorreosOld, $new);
            }
        }


        $contrato->descripcion = $request->input("descripcion");
        $contrato->fecha_inicio = $request->input("fecha_inicio");
        $contrato->fecha_fin = $request->input("fecha_fin");
        $contrato->cliente_id = $request->input("cliente");
        $contrato->pais_id = $request->input("pais")['id'];
        $contrato->area_id = $request->input("area")['id'];
        $contrato->solucion = $request->input("solucion");
        $contrato->marca = $request->input("marca");
        $contrato->correos = implode(",", $arrayCorreosOld);
        $contrato->adjunto = implode(",", $arrayAdjuntosOld);
        $contrato->observacion = $request->input("observacion");
        $contrato->estado = 1;
        $contrato->save();
        // elimina servicios anteriores
        $serviciosOld = ContratoServicio::where('contrato_id',$contrato->id)->get();
        foreach ($serviciosOld as $item) {
                $item->delete();
        }
        //crea nuevos servicios
        foreach ($arrayServicios as $item) {
            # code...
            $contrato_servicio = new ContratoServicio([
                        'contrato_id' => $contrato->id,
                        'servicio_id' => $item['id'],
                        'estado' => 1,
                        'is_deleted' => 0
                    ]);
            $contrato_servicio->save();
        }


        return response()->json('Contrato updated!');
    }

    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        $contrato->delete();

        return response()->json('Product deleted!');
    }
}
