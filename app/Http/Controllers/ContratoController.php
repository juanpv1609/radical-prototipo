<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Contrato;
use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Models\ContratoServicio;
use App\Models\ContratoDestinatario;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SendMailController;

class ContratoController extends Controller
{
    public function index()
    {
        //$products = Product::all()->toArray();
        $contratos = Contrato::with('cliente', 'pais', 'area', 'tarea','estado_contrato','servicios','destinatarios')->get()->toArray();

        return $contratos;
    }

    public function store(Request $request)
    {


        $arrayCorreos = $request->input("correos");
        $arrayEstructuraInforme = $request->input("estructura_informe");
        $arrayAdjuntos = $request->input("adjuntos");
        $arrayServicios = $request->input("servicios");
        $arrayDestinatarios = $request->input("destinatarios");

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
            'estructura_informe' => implode(",",$arrayEstructuraInforme)
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

        foreach ($arrayDestinatarios as $item){

            $contrato_destinatario = new ContratoDestinatario([
                'contrato_id' => $contrato->id,
                'destinatario_id' => $item['id'],
                'estado' => 1,
                'is_deleted' => 0
            ]);
            $contrato_destinatario->save();

        }

        return response()->json('Contrato created!');
    }

    public function show($id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'tarea','servicios','destinatarios')->find($id);
        return response()->json($contrato);
    }

    public function update($id, Request $request)
    {
        $arrayCorreos = $request->input("correos");
        $arrayEstructuraInforme = $request->input("estructura_informe");
        $arrayAdjuntos = $request->input("adjuntos");
        $arrayServicios = $request->input("servicios");
        $arrayDestinatarios = $request->input("destinatarios");

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

        /*$arrayEstructuraInformeOld = explode(",", $contrato->estructura_informe);
        if ((isset($arrayEstructuraInforme)>0) && (count($arrayEstructuraInformeOld)>0)){
            foreach ($arrayEstructuraInforme as $new) {
                # code...
                array_push($arrayEstructuraInformeOld, $new);
            }
        }*/


        $contrato->descripcion = $request->input("descripcion");
        $contrato->fecha_inicio = $request->input("fecha_inicio");
        $contrato->fecha_fin = $request->input("fecha_fin");
        $contrato->cliente_id = $request->input("cliente");
        $contrato->pais_id = $request->input("pais")['id'];
        $contrato->area_id = $request->input("area")['id'];
        $contrato->solucion = $request->input("solucion");
        $contrato->marca = $request->input("marca");
        $contrato->correos = isset($arrayCorreosOld) ? implode(",", $arrayCorreosOld) : null;
        $contrato->observacion = $request->input("observacion");
        $contrato->estado = 1;
        $contrato->adjunto = implode(",", $arrayAdjuntosOld);
        $contrato->estructura_informe = isset($arrayEstructuraInforme) ? implode(",", $arrayEstructuraInforme) : null;
        $contrato->save();
        
        // elimina servicios anteriores
        $serviciosOld = ContratoServicio::where('contrato_id',$contrato->id)->get();
        foreach ($serviciosOld as $item) {
                $item->delete();
        }

        //elimina los destinatarios anteriores
        $destinatariosOld = ContratoDestinatario::where('contrato_id',$contrato->id)->get();
        foreach ($destinatariosOld as $item) {
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

        //crea nuevos destinatarios
        foreach ($arrayDestinatarios as $item) {

            $contrato_destinatario = new ContratoDestinatario([
                        'contrato_id' => $contrato->id,
                        'destinatario_id' => $item['id'],
                        'estado' => 1,
                        'is_deleted' => 0
                    ]);
            $contrato_destinatario->save();
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
