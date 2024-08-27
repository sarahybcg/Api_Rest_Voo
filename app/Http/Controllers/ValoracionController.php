<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ValoracionController extends Controller
{ 
    public function index()
    {
        return response()->json([
            'error' => false,
            'data' => Valoracion::all(),
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'estrellas' => 'required|integer|min:1|max:5',
            ]);

            $valoracion = Valoracion::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Valoración creada con éxito',
                'data' => $valoracion,
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
                'mensaje' => 'Error al crear la valoración',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Valoracion $valoracion)
    {
        return response()->json([
            'error' => false,
            'data' => $valoracion,
        ], 200);
    }
 
    public function update(Request $request, Valoracion $valoracion)
    {
        try {
            $validatedData = $request->validate([
                'estrellas' => 'required|integer|min:1|max:5',
            ]);

            $valoracion->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Valoración actualizada con éxito',
                'data' => $valoracion,
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
                'mensaje' => 'Error al actualizar la valoración',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Valoracion $valoracion)
    {
        try {
            $valoracion->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Valoración eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la valoración',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
