<?php

namespace App\Http\Controllers;

use App\Models\Condicion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class CondicionController extends Controller
{ 
    public function index()
    {
        $condiciones = Condicion::all();

        return response()->json([
            'error' => false,
            'data' => $condiciones,
        ], 200);
    } 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'condicion' => 'required|string|max:50',
            ]);

            $condicion = Condicion::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Condición creada con éxito',
                'data' => $condicion,
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
                'mensaje' => 'Error al crear la condición',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Condicion $condicion)
    {
        return response()->json([
            'error' => false,
            'data' => $condicion,
        ], 200);
    } 
    public function update(Request $request, Condicion $condicion)
    {
        try {
            $validatedData = $request->validate([
                'condicion' => 'required|string|max:50',
            ]);

            $condicion->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Condición actualizada con éxito',
                'data' => $condicion,
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
                'mensaje' => 'Error al actualizar la condición',
                'exception' => $e->getMessage(),
            ], 500);
        }
    } 
    public function destroy(Condicion $condicion)
    {
        try {
            $condicion->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Condición eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la condición',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
