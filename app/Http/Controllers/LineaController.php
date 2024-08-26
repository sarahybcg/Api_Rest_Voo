<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LineaController extends Controller
{
    public function index()
    {
        return Linea::all();
    }
    public function store(Request $request)
    {
        try {
            // Valida los datos antes de guardarlos
            $validatedData = $request->validate([
                'Linea_' => 'required|string|max:15|unique:lineas,Linea_',
                'idUsuario' => [
                    'required',
                    'exists:usuarios,id',
                    function ($attribute, $value, $fail) {
                        // Verifica si ya existe una línea con este idUsuario
                        if (Linea::where('idUsuario', $value)->exists()) {
                            $fail('El usuario ya está asociado a otra línea.');
                        }
                    }
                ],
            ]);

            $linea = Linea::create($validatedData);

            // Devuelve una respuesta exitosa
            return response()->json([
                'error' => false,
                'mensaje' => 'Línea creada con éxito',
                'data' => $linea,
            ], 201);
        } catch (ValidationException $e) {
            // Maneja errores de validación
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Maneja otros errores
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al crear la línea',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $linea = Linea::findOrFail($id);

            return response()->json([
                'error' => false,
                'data' => $linea,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Linea no encontrada',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al obtener la linea',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, Linea $linea)
    {
        try { 
            $validatedData = $request->validate([
                
            'Linea_' => 'required|string|max:15|unique:lineas,Linea_',
                'idUsuario' => [
                    'required',
                    'exists:usuarios,id',
                    function ($attribute, $value, $fail) {
                        // Verifica si ya existe una línea con este idUsuario
                        if (Linea::where('idUsuario', $value)->exists()) {
                            $fail('El usuario ya está asociado a otra línea.');
                        }
                    }
                ],
            ]);
 
            $linea->Linea_ = $validatedData['Linea_'];

            if ($linea->save()) {
                return response()->json([
                    'error' => false,
                    'mensaje' => 'Linea actualizada con éxito',
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se pudo actualizar la linea',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy(Linea $linea)
    {
        try { 
            $linea->delete();
 
            return response()->json([
                'error' => false,
                'mensaje' => 'Linea eliminada con éxito',
            ], 200);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la linea',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
