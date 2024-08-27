<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\error;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        try {
            // valida los datos antes de guardarlos
            $validatedData = $request->validate([
                'CI_' => 'required|string|max:20|unique:usuarios,CI_',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'telefono_' => 'required|string|max:15',
                'fechaNacimiento' => 'required|date',
                'clave' => 'required|string|min:6',
                'idRol' => 'required|exists:rols,id',
            ]);

            // encripta la contraseña 
            $validatedData['clave'] = Hash::make($validatedData['clave']);

            // crea el   usuario
            $usuario = Usuario::create($validatedData);

            // devuelve una respuesta exitosa
            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario creado con éxito',
                'data' => $usuario,
            ], 201);
        } catch (ValidationException $e) {
            // maneja errores de validación
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
    public function show( $id)
    {
        try {
            // Encuentra el usuario por ID o lanza una excepción si no se encuentra
            $usuario = Usuario::findOrFail($id);

            // Retorna el usuario en formato JSON
            return response()->json([
                'error' => false,
                'data' => $usuario,
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
    public function update(Request $request, Usuario $usuario)
    {
        try {
            // Valida los datos entrantes
            $validatedData = $request->validate([
                'CI_' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'telefono_' => 'required|string|max:15',
                'fechaNacimiento' => 'required|date',
                'clave' => 'nullable|string|min:6',
                'idRol' => 'required|exists:rols,id',
            ]);

            // Verifica si el nuevo CI_ ya está en uso por otro usuario
            if (Usuario::where('CI_', $validatedData['CI_'])
                ->where('id', '!=', $usuario->id) // Asegura que no sea el mismo usuario
                ->exists()
            ) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El CI_ ya está en uso por otro usuario',
                ], 400);
            }

            // Actualiza los datos del usuario
            $usuario->CI_ = $validatedData['CI_'];
            $usuario->nombre = $validatedData['nombre'];
            $usuario->apellido = $validatedData['apellido'];
            $usuario->telefono_ = $validatedData['telefono_'];
            $usuario->fechaNacimiento = $validatedData['fechaNacimiento'];

            // Encripta la nueva contraseña si se proporciona
            if (!empty($validatedData['clave'])) {
                $usuario->clave = Hash::make($validatedData['clave']);
            }

            $usuario->idRol = $validatedData['idRol'];

            // Guarda los cambios en la base de datos
            if ($usuario->save()) {
                return response()->json([
                    'error' => false,
                    'mensaje' => 'Usuario actualizado con éxito',
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se pudo actualizar el usuario',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy(Usuario $usuario)  
    {
         try {
            // Elimina el usuario
            $usuario->delete();

            // Devuelve una respuesta exitosa
            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            // Maneja cualquier error inesperado
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el usuario',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
