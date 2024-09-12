<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Rol;

class ConductorPasajeroAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'telefono_' => 'required',
            'clave' => 'required',
        ]);
    
        $telefono = $request->input('telefono_');
        $clave = $request->input('clave');
    
        $usuario = Usuario::where('telefono_', $telefono)->first();
    
        if (!$usuario || !Hash::check($clave, $usuario->clave)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    
        $rol = $usuario->roles()->first();
    
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
    
        if ($rol->nombreRol === 'conductor' || $rol->nombreRol === 'pasajero') {
            return response()->json([
                'token' => $usuario->createToken('YourAppName')->plainTextToken,
                'user' => [
                    'id' => $usuario->id,
                    'telefono_' => $usuario->telefono_,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'role' => $rol->nombreRol,
                ],
            ]);
        } else {
            return response()->json(['message' => 'Rol no autorizado'], 403);
        }
    }
    
}
