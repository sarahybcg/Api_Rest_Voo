<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PropietarioController extends Controller
{ 
    public function index()
    {
        $propietarios = Propietario::all();

        return response()->json([
            'error' => false,
            'data' => $propietarios,
        ], 200);
    } 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'carnetCirculacion' => 'required|string',
            ]);

            $propietario = Propietario::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Propietario creado con éxito',
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
                'mensaje' => 'Error al crear el propietario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Propietario $propietario)
    {
        return response()->json([
            'error' => false,
            'data' => $propietario,
        ], 200);
    } 
    
    public function update(Request $request, Propietario $propietario)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'carnetCirculacion' => 'required|string',
            ]);

            $propietario->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Propietario actualizado con éxito',
                'data' => $propietario,
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
                'mensaje' => 'Error al actualizar el propietario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    } 
    public function destroy(Propietario $propietario)
    {
        try {
            $propietario->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Propietario eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el propietario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
