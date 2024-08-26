<?php

namespace App\Http\Controllers;

 
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class RolController extends Controller
{ 
    public function index()
    {
         
        return Rol::all();
  
    }
 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombreRol' => 'required|string|max:30'
            ]);

            $rol = Rol::create($validatedData);

            // devuelve una respuesta exitosa
            return response()->json([
                'error' => false,
                'mensaje' => 'Rol creado con éxito',
                'data' => $rol,
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos de entrada no válidos',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // otros errores
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al crear el usuario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show($id)
    {
        try { 
            $rol = Rol::findOrFail($id);
            // Retorna el usuario en formato JSON
            return response()->json([
                'error' => false,
                'data' => $rol,
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Maneja el caso en que el usuario no se encuentra
            return response()->json([
                'error' => true,
                'mensaje' => 'Usuario no encontrado',
            ], 404);
        } catch (\Exception $e) {
            // Maneja cualquier otro error inesperado
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al obtener el usuario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function update(Request $request, Rol $rol)
    {
        try {
            // Valida los datos entrantes
            $validatedData = $request->validate([
                
                'nombreRol' => 'required|string|max:20', 
            ]);
 
            $rol->nombreRol = $validatedData['nombreRol'];

            if ($rol->save()) {
                return response()->json([
                    'error' => false,
                    'mensaje' => 'Rol actualizado con éxito',
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se pudo actualizar el rol',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Rol $rol)
    {
        try { 
            $rol->delete();
 
            return response()->json([
                'error' => false,
                'mensaje' => 'Rol eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            // Maneja cualquier error inesperado
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el rol',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
