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
            'activo' => 'required|boolean', // Validación para el estado activo/inactivo
            'idRol' => 'required|integer|exists:rols,id' // Asegura que el rol existe en la tabla rols
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
        $usuario->activo = $validatedData['activo']; // Actualiza el estado de activo/inactivo

        // Encripta la nueva contraseña si se proporciona
        if (!empty($validatedData['clave'])) {
            $usuario->clave = Hash::make($validatedData['clave']);
        }

        // Actualiza el rol del usuario en la tabla pivote 'usuarios_rol'
        $usuario->roles()->sync([$validatedData['idRol']]);

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
