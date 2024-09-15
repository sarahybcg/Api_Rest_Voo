<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\Usuario;

class SolicitudController extends Controller
{
    public function buscarUsuarioPorTelefono(Request $request)
{
    $request->validate([
        'telefono' => 'required|exists:usuarios,telefono_',
    ]);

    $usuario = Usuario::where('telefono_', $request->telefono)->first();

    if ($usuario) {
        return response()->json([
            'message' => 'Usuario encontrado.',
            'data' => [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'telefono' => $usuario->telefono_,
            ]
        ], 200);
    }

    return response()->json(['message' => 'Usuario no encontrado.'], 404);
}


public function enviarSolicitud(Request $request)
{ 
    $request->validate([
        'solicitante_id' => 'required|integer|exists:usuarios,id',
        'telefono' => 'required|exists:usuarios,telefono_',
    ]);

     
    $receptor = Usuario::where('telefono_', $request->telefono)->first();

    if ($receptor) {
         
        Solicitud::create([
            'solicitante_id' => $request->input('solicitante_id'),  
            'receptor_id' => $receptor->id,
            'estado' => 'PENDIENTE',  
        ]);

        return response()->json(['message' => 'Solicitud enviada con éxito.'], 200);
    }

    return response()->json(['message' => 'Usuario no encontrado.'], 404);
}

public function responderSolicitud(Request $request, $id)
{ 
    $request->validate([
        'estado' => 'required|in:aceptada,rechazada',
        'receptor_id' => 'required|integer|exists:usuarios,id',
    ]);
 
    $solicitud = Solicitud::findOrFail($id);

     
    if ($solicitud->receptor_id !== $request->input('receptor_id')) {
        return response()->json(['message' => 'No tienes permiso para modificar esta solicitud.'], 403);
    }

    // Actualizar el estado de la solicitud
    $solicitud->update([
        'estado' => $request->estado,
    ]);

    if ($request->estado === 'aceptada') {
        // Obtener la información del conductor que está aceptando la solicitud
        $conductor = Usuario::find($solicitud->receptor_id)->conductor;

        if ($conductor) { 

            $autobus = $conductor->usuario->autobus->first();
             
            $linea = $autobus ? $autobus->linea : null;
 
            $trayecto = $linea ? $linea->trayectos->first() : null;
 
            return response()->json([
                'message' => 'Solicitud aceptada con éxito.',
                'autobus' => $autobus ? [
                    'Placa_' => $autobus->Placa_,
                    'capacidad' => $autobus->capacidad,
                    'modelo' => $autobus->modelo ? $autobus->modelo->nombre : 'Modelo no disponible',
                    'marca' => $autobus->modelo && $autobus->modelo->marca ? $autobus->modelo->marca->nombre : 'Marca no disponible',
                ] : 'Autobús no disponible',
                'linea' => $linea ? [
                    'nombreLinea' => $linea->Linea_,
                ] : 'Línea no disponible',
                'trayecto' => $trayecto ? [
                    'nombre_trayecto' => $trayecto->nombre_trayecto,
                    'origen' => $trayecto->origen,
                    'destino' => $trayecto->destino,
                    'distancia' => $trayecto->distancia,
                ] : 'Trayecto no disponible',
            ], 200);
        }
    }

    return response()->json(['message' => 'Solicitud actualizada con éxito.'], 200);
}


public function solicitudesEnviadas(Request $request)
{
    $solicitante_id = $request->input('solicitante_id');
 
    $solicitudes = Solicitud::where('solicitante_id', $solicitante_id)->get();
 
    $solicitudesConDetalles = $solicitudes->map(function ($solicitud) use ($solicitante_id) {
        $receptor = Usuario::find($solicitud->receptor_id);

        return [
            'id' => $solicitud->id,
            'estado' => $solicitud->estado,
            'created_at' => $solicitud->created_at,
            'updated_at' => $solicitud->updated_at,
            'receptor' => [
                'nombre' => $receptor->nombre,
                'apellido' => $receptor->apellido,
                'telefono' => $receptor->telefono_,
            ],
        ];
    });

    return response()->json($solicitudesConDetalles, 200);
}



public function solicitudesRecibidas(Request $request)
{
    $receptor_id = $request->input('receptor_id');

    $solicitudes = Solicitud::where('receptor_id', $receptor_id)->get();
 
    $solicitudesConDetalles = $solicitudes->map(function ($solicitud) use ($receptor_id) {
        $solicitante = Usuario::find($solicitud->solicitante_id);

        return [
            'id' => $solicitud->id,
            'estado' => $solicitud->estado,
            'created_at' => $solicitud->created_at,
            'updated_at' => $solicitud->updated_at,
            'solicitante' => [
                'nombre' => $solicitante->nombre,
                'apellido' => $solicitante->apellido,
                'telefono' => $solicitante->telefono_,
            ],
        ];
    });

    return response()->json($solicitudesConDetalles, 200);
}

}
