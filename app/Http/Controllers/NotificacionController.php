<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class NotificacionController extends Controller
{
     
    public function index()
    {
        $notificaciones = Notificacion::all();

        return response()->json([
            'error' => false,
            'data' => $notificaciones,
        ], 200);
    }

     
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'titulo' => 'required|string|max:80',
                'descripcion' => 'required|string|max:255',
                'fechaEnvio' => 'required|date',
                'idPrioridad' => 'required|exists:prioridads,id',
            ]);

            $notificacion = Notificacion::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificación creada con éxito',
                'data' => $notificacion,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al crear la notificación',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Notificacion $notificacion)
    {
        return response()->json([
            'error' => false,
            'data' => $notificacion,
        ], 200);
    }

 
    public function update(Request $request, Notificacion $notificacion)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'titulo' => 'required|string|max:80',
                'descripcion' => 'required|string|max:255',
                'fechaEnvio' => 'required|date',
                'idPrioridad' => 'required|exists:prioridads,id',
            ]);

            $notificacion->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificación actualizada con éxito',
                'data' => $notificacion,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al actualizar la notificación',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

  
    public function destroy(Notificacion $notificacion)
    {
        try {
            $notificacion->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificación eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la notificación',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
