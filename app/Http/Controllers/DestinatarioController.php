<?php


namespace App\Http\Controllers;

use App\Models\Destinatario;
use Illuminate\Http\Request;

class DestinatarioController extends Controller
{
    public function index()
    {
        $cond = ['is_deleted' => 0];

        $destinatarios = Destinatario::where($cond)->get()->toArray();

        return $destinatarios;
    }

    //Crear un nuevo destinatario de los correos
    public function store(Request $request){

        $destinatario = new Destinatario([
            'name' => $request->input('name'),
            'email' => $request->input('email')
            
        ]);
        
        $destinatario->save();

        return response()->json('Destinatario created!');
    }

    //Mostrar los destinatarios de los correos enviados
    public function show($id){

        $destinatario = Destinatario::find($id);
        return response()->json($destinatario);
    }

    //Actualizar la información de un destinatario
    public function update($id, Request $request){

        $destinatario = Destinatario::find($id);
        $destinatario->update($request->all());

        return response()->json('Destinatario updated!');
    }

    //Cambiar el estado del destinatario borrado
    public function destroy($id) {

        $destinatario = Destinatario::find($id);
        $destinatario->is_deleted = 1;
        $destinatario->save();

        return response()->json('Destinatario deleted!');
    }
}