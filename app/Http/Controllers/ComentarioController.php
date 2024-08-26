<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;   
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ComentarioController extends Controller
{ 
    public function index()
    {
        $comentarios = Comentario::with('experiencia')->get();

        return response()->json([
            'error' => false,
            'data' => $comentarios,
        ], 200);
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'comentario' => 'required|string',
                'idExperiencia' => 'required|exists:experiencias,id',
            ]);

            $comentario = Comentario::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Comentario creado con éxito',
                'data' => $comentario,
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
                'mensaje' => 'Error al crear el comentario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Comentario $comentario)
    {
        return Comentario::all();
    }
 
    public function update(Request $request, Comentario $comentario)
    {
        try {
            $validatedData = $request->validate([
                'comentario' => 'required|string',
                'idExperiencia' => 'required|exists:experiencias,id',
            ]);

            $comentario->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Comentario actualizado con éxito',
                'data' => $comentario,
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
                'mensaje' => 'Error al actualizar el comentario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Comentario $comentario)
    {
        try {
            $comentario->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Comentario eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el comentario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
