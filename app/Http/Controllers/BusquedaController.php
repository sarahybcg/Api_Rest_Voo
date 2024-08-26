<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BusquedaController extends Controller
{
    
    public function index()
    {
        $busquedas = Busqueda::all();

        return response()->json([
            'error' => false,
            'data' => $busquedas,
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'consulta' => 'required|string|max:50',
                'fechaBusqueda' => 'nullable|date',
                'resultado' => 'nullable|string',
            ]);

            $busqueda = Busqueda::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda creada con éxito',
                'data' => $busqueda,
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
                'mensaje' => 'Error al crear la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Busqueda $busqueda)
    {
        return response()->json([
            'error' => false,
            'data' => $busqueda,
        ], 200);
    }

    
    public function update(Request $request, Busqueda $busqueda)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'consulta' => 'required|string|max:50',
                'fechaBusqueda' => 'nullable|date',
                'resultado' => 'nullable|string',
            ]);

            $busqueda->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda actualizada con éxito',
                'data' => $busqueda,
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
                'mensaje' => 'Error al actualizar la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    
    public function destroy(Busqueda $busqueda)
    {
        try {
            $busqueda->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
