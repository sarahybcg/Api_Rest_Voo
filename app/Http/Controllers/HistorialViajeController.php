<?php

namespace App\Http\Controllers;

use App\Models\HistorialViaje;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HistorialViajeController extends Controller
{ 
    public function index()
    {
        $historialViajes = HistorialViaje::all();

        return response()->json([
            'error' => false,
            'data' => $historialViajes,
        ], 200); 
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idTrayecto' => 'required|exists:trayectos,id',
                'idAutobus' => 'required|exists:autobuses,id',
                'idUsuario' => 'required|exists:usuarios,id',
                'tiempo_inicio' => 'required|date_format:Y-m-d H:i:s',
                'tiempo_fin' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:tiempo_inicio',
                'estado' => 'in:en progreso,completado,cancelado',
            ]);

            $historialViaje = HistorialViaje::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Historial de viaje creado con éxito',
                'data' => $historialViaje,
            ], 201);
        } 
        catch (ValidationException $e) 
        {
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al crear el historial de viaje',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(HistorialViaje $historialViaje)
    { 
        return response()->json([
            'error' => false,
            'data' => $historialViaje,
        ], 200);
 
    }
 
    public function update(Request $request, HistorialViaje $historialViaje)
    {
        try {
            $validatedData = $request->validate([
                'idTrayecto' => 'required|exists:trayectos,id',
                'idAutobus' => 'required|exists:autobuses,id',
                'idUsuario' => 'required|exists:usuarios,id',
                'tiempo_inicio' => 'required|date_format:Y-m-d H:i:s',
                'tiempo_fin' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:tiempo_inicio',
                'estado' => 'in:en progreso,completado,cancelado',
            ]);

            $historialViaje->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Historial de viaje actualizado con éxito',
                'data' => $historialViaje,
            ], 200);
        }
         catch (ValidationException $e) 
         {
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al actualizar el historial de viaje',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(HistorialViaje $historialViaje)
    {
        try {
            $historialViaje->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Historial de viaje eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el historial de viaje',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
