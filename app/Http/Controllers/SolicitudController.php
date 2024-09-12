<?php

namespace App\Http\Controllers;

use App\Models\solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Conductor;

class SolicitudController extends Controller
{  
   
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'telefonoPropietario' => 'required|numeric',
            'idRol' => 'required|exists:rols,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Encuentra al propietario por número de teléfono
        $propietario = Usuario::where('telefono_', $request->telefonoPropietario)
            ->whereHas('roles', function ($query) {
                $query->where('nombreRol', 'Propietario'); // Asumiendo que el rol se llama 'Propietario'
            })
            ->first();

        if (!$propietario) {
            return response()->json(['message' => 'Propietario no encontrado.'], 404);
        }

        $conductor = Conductor::where('idUsuario', $request->user()->id)->first();

        if (!$conductor) {
            return response()->json(['message' => 'Conductor no encontrado.'], 404);
        }

        // Crear la solicitud
        $solicitud = Solicitud::create([
            'idConductor' => $conductor->id,
            'idPropietario' => $propietario->id,
            'idRol' => $request->idRol,
            'estado' => 'pendiente',
        ]);

        return response()->json(['message' => 'Solicitud enviada correctamente.', 'solicitud' => $solicitud], 201);
    }

    public function update(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:aprobado,rechazado',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $solicitud->estado = $request->estado;
        $solicitud->save();

        return response()->json(['message' => 'Estado de la solicitud actualizado correctamente.', 'solicitud' => $solicitud], 200);
    } 
}
