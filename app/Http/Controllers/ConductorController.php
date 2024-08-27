<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConductorController extends Controller
{ 
    public function index()
    {
        $conductors = Conductor::all();

        return response()->json([
            'error' => false,
            'data' => $conductors,
        ], 200);
    } 

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'licenciaConducir' => 'required|string',
            ]);

            $propietario = Conductor::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Conductor creado con éxito',
                'data' => $propietario,
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
                'mensaje' => 'Error al crear el conductor',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Conductor $conductor)
    {
        return response()->json([
            'error' => false,
            'data' => $conductor,
        ], 200);
    }
 
    public function update(Request $request, Conductor $conductor)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'licenciaConducir' => 'required|string',
            ]);

            $conductor->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Conductor actualizado con éxito',
                'data' => $conductor,
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
                'mensaje' => 'Error al actualizar el conductor',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Conductor $conductor)
    {
        try {
            $conductor->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Conductor eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el conductor',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
