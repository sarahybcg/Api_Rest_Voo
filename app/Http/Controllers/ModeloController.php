<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ModeloController extends Controller
{ 
    public function index()
    {
        $modelos = Modelo::with('marca')->get();

        return response()->json([
            'error' => false,
            'data' => $modelos,
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
                'idMarca' => 'required|exists:marcas,id',
            ]);

            $modelo = Modelo::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Modelo creado con éxito',
                'data' => $modelo,
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
                'mensaje' => 'Error al crear el modelo',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Modelo $modelo)
    {
        $modelo->load('marca');

        return response()->json([
            'error' => false,
            'data' => $modelo,
        ], 200);
    }
 
    public function update(Request $request, Modelo $modelo)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
                'idMarca' => 'required|exists:marcas,id',
            ]);

            $modelo->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Modelo actualizado con éxito',
                'data' => $modelo,
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
                'mensaje' => 'Error al actualizar el modelo',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Modelo $modelo)
    {
        try {
            $modelo->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Modelo eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el modelo',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
