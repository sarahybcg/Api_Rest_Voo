<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MarcaController extends Controller
{
     
    public function index()
    {
        $marcas = Marca::all();

        return response()->json([
            'error' => false,
            'data' => $marcas,
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
            ]);

            $marca = Marca::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca creada con éxito',
                'data' => $marca,
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
                'mensaje' => 'Error al crear la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Marca $marca)
    {
        return response()->json([
            'error' => false,
            'data' => $marca,
        ], 200);
    }
 
    public function update(Request $request, Marca $marca)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
            ]);

            $marca->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca actualizada con éxito',
                'data' => $marca,
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
                'mensaje' => 'Error al actualizar la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Marca $marca)
    {
        try {
            $marca->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
