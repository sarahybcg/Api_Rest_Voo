<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use App\Models\RolUsuario;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\error;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    public function index(Request $request)
{
    // Obtener palabra clave de búsqueda, rol de búsqueda, página y tamaño de página
    $keyword = $request->input('search');
    $roleFilter = $request->input('role');
    $page = $request->input('page', 1); // Valor por defecto es 1
    $pageSize = $request->input('pageSize', 10); // Valor por defecto es 10

    // Validar que pageSize sea un número positivo
    if ($pageSize <= 0) {
        return response()->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'El tamaño de la página debe ser un número positivo.'
        ], Response::HTTP_BAD_REQUEST);
    }

    // Iniciar la consulta
    $query = Usuario::query();

    // Aplicar filtro de búsqueda si existe
    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('nombre', 'LIKE', "%{$keyword}%")
              ->orWhere('apellido', 'LIKE', "%{$keyword}%")
              ->orWhere('CI_', 'LIKE', "%{$keyword}%");
        });
    }

    // Aplicar filtro por rol si existe
    if ($roleFilter) {
        $query->whereHas('roles', function($q) use ($roleFilter) {
            $q->where('nombreRol', 'LIKE', "%{$roleFilter}%");
        });
    }

    // Obtener usuarios con sus roles
    $usuarios = $query->with('roles')->paginate($pageSize, ['*'], 'page', $page);

    // Si no hay usuarios, retorna un mensaje de error
    if ($usuarios->isEmpty()) {
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'Usuario no encontrado'
        ], Response::HTTP_NOT_FOUND);
    }

    // Formatear los usuarios con sus roles
    $usuariosFormatted = $usuarios->getCollection()->map(function ($usuario) {
        $roles = $usuario->roles->pluck('nombreRol'); // Asegúrate de que la columna 'nombreRol' exista en la tabla 'roles'
        return [
            'CI_' => $usuario->CI_,
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'telefono_' => $usuario->telefono_,
            'fechaNacimiento' => $usuario->fechaNacimiento,
            'activo' => $usuario->activo,
            'roles' => $roles, // Lista de roles
        ];
    });

    return response()->json([
        'data' => $usuariosFormatted,
        'pagination' => [
            'total' => $usuarios->total(),
            'per_page' => $usuarios->perPage(),
            'current_page' => $usuarios->currentPage(),
            'last_page' => $usuarios->lastPage(),
        ],
        'message' => 'Lista de usuarios',
        'status' => Response::HTTP_OK
    ], Response::HTTP_OK);
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
    public function show(Usuario $usuario)
    {
        return response()->json([
            'error' => false,
            'data' => $usuario,
        ], 200);
    }



    public function update(Request $request, $CI_)
    {
        Log::info('El CI_ recibido es: ' . $CI_);
    
        try {
            // Busca el usuario por CI_
            $usuario = Usuario::where('CI_', $CI_)->first();
    
            if (!$usuario) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Usuario no encontrado',
                ], 404);
            }
    
            // Valida los datos entrantes
            $validatedData = $request->validate([
                'CI_' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'telefono_' => 'required|string|max:15',
                'fechaNacimiento' => 'required|date',
                'clave' => 'nullable|string|min:6',
                'activo' => 'required|boolean',
                'roles' => 'nullable|string|max:255', // 'roles' es opcional
            ]);
    
            // Verifica si el nuevo CI_ ya está en uso por otro usuario
            if (Usuario::where('CI_', $validatedData['CI_'])
                ->where('id', '!=', $usuario->id)
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
            $usuario->activo = $validatedData['activo'];
    
            // Encripta la nueva contraseña si se proporciona
            if (!empty($validatedData['clave'])) {
                $usuario->clave = Hash::make($validatedData['clave']);
            }
    
            // Si 'roles' está presente y no está vacío, sincroniza los roles
            if (!empty($validatedData['roles'])) {
                // Busca el rol por nombreRol
                $rol = Rol::where('nombreRol', $validatedData['roles'])->first();
    
                if (!$rol) {
                    return response()->json([
                        'error' => true,
                        'mensaje' => 'Rol no encontrado',
                    ], 400);
                }
    
                // Actualiza la relación en la tabla pivote con el rol encontrado
                $usuario->roles()->sync([$rol->id]);
            }
    
            // Guarda los cambios en el usuario
            $usuario->save();
    
            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario actualizado con éxito',
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            return response()->json([
                'error' => true,
                'mensaje' => 'Error de validación: ' . $e->getMessage(),
                'detalles' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            Log::error('Error en la actualización del usuario: ' . $e->getMessage());
    
            return response()->json([
                'error' => true,
                'mensaje' => 'Error en el servidor: ' . $e->getMessage(),
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
