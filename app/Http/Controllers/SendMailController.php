<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Mail\ContratoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index()
    {
        //
    }
    public function sendMailsClient($contrato_id)
    {
        $contrato = Contrato::with('cliente', 'pais', 'area', 'tarea')->find($contrato_id);
        $correos = explode(",", $contrato->correos);
        $details = [

        'title' => 'Nuevo contrato registrato',
        'body' => 'Se ha registrado un nuevo contrato, a continuacion los detalles',
        'cliente' => $contrato->cliente->razon_social,
        'fecha_inicio' => $contrato->fecha_inicio,
        'fecha_fin' => $contrato->fecha_fin,
        'area' => $contrato->area->nombre,
        'solucion' => $contrato->solucion,

        ];
        foreach ($correos as $correo) {
            Mail::to($correo)->send(new ContratoEmail($details));

        }
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
