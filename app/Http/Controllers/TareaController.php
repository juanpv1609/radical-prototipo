<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tarea;
use App\Models\Tareas;
use App\Models\Contrato;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    private $tareas;
    public function index()
    {
        //$products = Product::all()->toArray();
        $cond=[
            'responsable' => auth()->user()->id
        ];
        if (auth()->user()->role==2) {
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
            ->orderBy('fecha')->get()->toArray();
        }else{

            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                        ->where($cond)->orderBy('fecha')->get()->toArray();
        }


        return $this->tareas;
    }
    public function tareasPorFecha($inicial,$final)
    {
        //$products = Product::all()->toArray();
        if (auth()->user()->role==2) {
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
            ->whereBetween('fecha',[$inicial,$final])
            ->orderBy('fecha')->get()->toArray();
        }else{
            $cond=[
                'responsable' => auth()->user()->id
            ];
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                        ->where($cond)
                        ->whereBetween('fecha',[$inicial,$final])
                        ->orderBy('fecha')->get()->toArray();
        }


        return $this->tareas;
    }
    public function tareasPorFechaCliente($cliente,$inicial,$final)
    {
        //$products = Product::all()->toArray();
        $contrato = Contrato::where('cliente_id', $cliente)->get(); //cambiar por get
        $contratosId = [];
        foreach ($contrato as $item) {
            array_push($contratosId, $item->id);
        }

        if (auth()->user()->role==2) {
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
            ->whereIn('contrato_id',$contratosId)
            ->whereBetween('fecha',[$inicial,$final])
            ->orderBy('fecha')->get()->toArray();
        }else{
            $cond=[
                'responsable' => auth()->user()->id,
            ];
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                        ->where($cond)
                        ->whereIn('contrato_id',$contratosId)
                        ->whereBetween('fecha',[$inicial,$final])
                        ->orderBy('fecha')->get()->toArray();
        }


        return $this->tareas;
    }
    public function tareasPorCliente($cliente)
    {
        //$products = Product::all()->toArray();
        $contrato = Contrato::where('cliente_id',$cliente)->get(); //cambiar por get
        $contratosId = [];
        foreach ($contrato as $item) {
            array_push($contratosId,$item->id);
        }
        if (auth()->user()->role==2) { // es admin
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
            ->whereIn('contrato_id',$contratosId)
            ->orderBy('fecha')->get()->toArray();
        }else{
            $cond=[
                'responsable' => auth()->user()->id
            ];
            $this->tareas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                        ->where($cond)
                        ->whereIn('contrato_id',$contratosId)
                        ->orderBy('fecha')->get()->toArray();
        }


        return $this->tareas;
    }

    public function store(Request $request)
    {
        $arrayCorreos = $request->input("correos_alerta");

        $data = $request->input("tareas");
        foreach ($data as $item) {
            $fecha = Carbon::createFromFormat('Y-m-d',$item['fecha']);
            $fecha_alerta = $fecha->subDays($item['alerta']);
            $tarea = new Tareas([
                    'descripcion' => $item['descripcion'],
                    'contrato_id' => $item['contrato_id'],
                    'frecuencia' => $item['frecuencia'],
                    'tipo_tarea' => $item['tipo_tarea'],
                    'dia_elegido' => $item['dia_elegido'],
                    //'ticket' => $item['id'],
                    'responsable' => $item['responsable'],
                    'fecha' => $item['fecha'],
                    'alerta' => $item['alerta'],
                    'fecha_alerta' => $fecha_alerta,
                    'correos_alerta' => implode(",", $item['correos_alerta']),
                    'estado' => 1,

                    ]);
                    $tarea->save();

        }




        return response()->json('Task created!');
    }

    public function show($id)
    {
        $contrato = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo')->find($id);
        return response()->json($contrato);
    }
    public function contratoTareas($id)
    {
        $contrato = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo')
        ->where('contrato_id','=',$id)
        ->orderBy('fecha')
        ->get();
        return response()->json($contrato);
    }
    public function update($id, Request $request)
    {
        $arrayAdjuntos = $request->input("adjuntos");

        $tarea = Tareas::find($id);
        // BORRAR ARCHIVOS ANTERIORES
        // if ($tarea->adjunto!=='') {
        //     $arrayAdjuntosOld = explode(",", $tarea->adjunto);
        //     foreach ($arrayAdjuntosOld as $item) {
        //         if (Storage::disk('local')->exists($item)) {
        //             Storage::delete($item);
        //         }
        //     }
        // }
        $date = Carbon::createFromFormat('Y-m-d',$request->input('fecha'));
        $fecha_alerta = $date->subDays($tarea->alerta);
        $tarea->descripcion = $request->input('descripcion');
        $tarea->estado = $request->input('estado');
        $tarea->fecha = $request->input('fecha');
        $tarea->fecha_alerta = $fecha_alerta;

        $tarea->observacion = $request->input('observacion');
        $tarea->responsable = $request->input('responsable');
        $tarea->ticket = $request->input('ticket');
        $tarea->tipo_tarea = $request->input('tipo_tarea');
        $tarea->correos_alerta = $request->input('correos_alerta');

        $tarea->adjunto = isset($arrayAdjuntos) ? implode(",", $arrayAdjuntos) : null;


        $tarea->save();

        return response()->json('Tarea updated!');
    }
    public function updateGroup(Request $request)
    {

        $data = $request->input("tareas");

        foreach ($data as $item) {
            //$tarea = Tareas::where('id', '=', $aux->id)->first();
                $tarea = Tareas::find($item['id']);
                $date = Carbon::createFromFormat('Y-m-d', $item['fecha']);
                $fecha_alerta = $date->subDays($tarea->alerta);

                $tarea->descripcion = $item['descripcion'];
                $tarea->responsable = $item['responsable'];
                $tarea->tipo_tarea = $item['tipo_tarea'];
                $tarea->fecha = $item['fecha'];
                $tarea->fecha_alerta = $fecha_alerta;

                $tarea->save();

        }



        return response()->json('Tarea updated!');
    }
    public function subirArchivo(Request $request)
    {
        $file = $request->file('file');
        $fileName = $request->file->getClientOriginalName();
        //$request->file->move(storage_path('app/public/'), $fileName);
       // $file->storeAs('public',$fileName);
        Storage::disk('local')->put($fileName, File($file));


        return response()->json(['archivo'=>$fileName]);
    }

    public function destroy($id)
    {
        $contrato = Tareas::find($id);
        $contrato->delete();

        return response()->json('Product deleted!');
    }
}
