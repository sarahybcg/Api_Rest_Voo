<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'CI_' => 'required',
            'clave' => 'required',
        ]);

        $ci = $request->input('CI_');
        $clave = $request->input('clave');

        $user = User::where('CI_', $ci)->first();

        if (!$user || !Hash::check($clave, $user->clave)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Obtener el primer rol asociado
        $role = $user->roles()->first();
        
        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        // Verificar si el rol es 'conductor' o 'pasajero'
        if ($role->nombreRol === 'conductor' || $role->nombreRol === 'pasajero') {
            return response()->json(['message' => 'Acceso denegado'], 403);
        }

        return response()->json([
            'token' => $user->createToken('YourAppName')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'CI_' => $user->CI_,
                'name' => $user->nombre,
                'role' => $role->nombreRol,
            ],
        ]);
    }
}