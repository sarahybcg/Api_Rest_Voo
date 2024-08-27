<?php

namespace App\Http\Controllers;

use App\Models\Trayecto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrayectoController extends Controller
{ 
    public function index()
    {
        $trayectos = Trayecto::all();

        return response()->json([
            'error' => false,
            'data' => $trayectos,
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_trayecto' => 'nullable|string|max:80',
                'descripcion' => 'required|string',
                'origen' => 'required|string|max:255',
                'destino' => 'required|string|max:255',
                'distancia' => 'nullable|numeric|min:0',
            ]);

            $trayecto = Trayecto::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto creado con éxito',
                'data' => $trayecto,
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
                'mensaje' => 'Error al crear el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Trayecto $trayecto)
    {
        return response()->json([
            'error' => false,
            'data' => $trayecto,
        ], 200);
    }
 
    public function update(Request $request, Trayecto $trayecto)
    {
        try {
            $validatedData = $request->validate([
                'nombre_trayecto' => 'nullable|string|max:80',
                'descripcion' => 'required|string',
                'origen' => 'required|string|max:255',
                'destino' => 'required|string|max:255',
                'distancia' => 'nullable|numeric|min:0',
            ]);

            $trayecto->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto actualizado con éxito',
                'data' => $trayecto,
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
                'mensaje' => 'Error al actualizar el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Trayecto $trayecto)
    {
        try {
            $trayecto->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
