<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $cond=[ 'is_deleted' => 0];
         $usuarios = User::where($cond)->get()->toArray();

        return ($usuarios);

    }
    public function indexAll()
    {
        $cond=['is_deleted' => 0];

        $usuarios = User::where($cond)->get()->toArray();

        return ($usuarios);

    }
    public function store(Request $request)
    {
        // $client = Cliente::create($request->all());
        // $clientes = Cliente::all();
        // return view('cliente.index')->with('clientes', $clientes);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->save();

        return response()->json('user created!');

    }
    public function usuarioUpdatePassword(Request $request)
    {

        $user = User::where('id',$request->user)->first();
        if (Hash::check( $request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            # code...
            return response()->json('user created!');
        }else{
            return response()->json('password error!');

        }


    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json('user updated!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        //$user->delete();
        $user->is_deleted=1;
        $user->save();
        return response()->json('user deleted!');
    }
}
