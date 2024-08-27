<?php

namespace App\Http\Controllers;

use App\Models\Prioridad;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PrioridadController extends Controller
{
     
    public function index()
    {
        $prioridades = Prioridad::all();

        return response()->json([
            'error' => false,
            'data' => $prioridades,
        ], 200);
    }

     
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombrePrioridad' => 'required|string|max:50',
            ]);

            $prioridad = Prioridad::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Prioridad creada con éxito',
                'data' => $prioridad,
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
                'mensaje' => 'Error al crear la prioridad',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

     
    public function show(Prioridad $prioridad)
    {
        return response()->json([
            'error' => false,
            'data' => $prioridad,
        ], 200);
    }

     
    public function update(Request $request, Prioridad $prioridad)
    {
        try {
            $validatedData = $request->validate([
                'nombrePrioridad' => 'required|string|max:50',
            ]);

            $prioridad->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Prioridad actualizada con éxito',
                'data' => $prioridad,
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
                'mensaje' => 'Error al actualizar la prioridad',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Prioridad $prioridad)
    {
        try {
            $prioridad->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Prioridad eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la prioridad',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
