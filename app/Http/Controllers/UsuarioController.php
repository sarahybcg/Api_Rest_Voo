<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{ 
    public function index()
    {
        $usuarios= Usuario::all();
        
        if($usuarios -> isEmpty())
        {
           $data= [
            'message'=>'No se ha registrado ningún usuario',
            'status'=>200
        ];
        return response()->json($data,404);
        }
        return response() -> json($usuarios, 200);
    } 

    public function store(Request $request)
    {
       //  
            } 
    public function show(Usuario $usuario)
    { 
        return $usuario;
    } 
    public function update(Request $request, Usuario $usuario)
    {
        //
    } 
    public function destroy(Usuario $usuario)
    {
        //
    }
}
