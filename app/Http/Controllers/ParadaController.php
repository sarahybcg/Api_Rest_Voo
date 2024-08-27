<?php

namespace App\Http\Controllers;

use App\Models\Parada;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ParadaController extends Controller
{
     
    public function index()
    {
        $paradas = Parada::all();

        return response()->json([
            'error' => false,
            'data' => $paradas,
        ], 200);
    }

     
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:200',
                'descripcion' => 'nullable|string',
                'latitud' => 'required|numeric|between:-90,90',
                'longitud' => 'required|numeric|between:-180,180',
            ]);

            $parada = Parada::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Parada creada con éxito',
                'data' => $parada,
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
                'mensaje' => 'Error al crear la parada',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

     
    public function show(Parada $parada)
    {
        return response()->json([
            'error' => false,
            'data' => $parada,
        ], 200);
    }

     
    public function update(Request $request, Parada $parada)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:200',
                'descripcion' => 'nullable|string',
                'latitud' => 'required|numeric|between:-90,90',
                'longitud' => 'required|numeric|between:-180,180',
            ]);

            $parada->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Parada actualizada con éxito',
                'data' => $parada,
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
                'mensaje' => 'Error al actualizar la parada',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

     
    public function destroy(Parada $parada)
    {
        try {
            $parada->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Parada eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la parada',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
