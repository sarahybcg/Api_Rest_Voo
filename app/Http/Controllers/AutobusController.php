<?php

namespace App\Http\Controllers;

use App\Models\Autobus;
use App\Models\Usuario;
use App\Models\Linea;
use App\Models\Condicion;
use App\Models\Modelo;
use App\Models\Marca;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
class AutobusController extends Controller
{

    //CAMBIO EN EL INDEX
    public function index(Request $request)
{
    // Obtener palabra clave de búsqueda, página y tamaño de página
    $keyword = $request->input('search');
    $page = $request->input('page', 1);
    $pageSize = $request->input('pageSize', 10);

    // Validar que pageSize sea un número positivo
    if ($pageSize <= 0) {
        return response()->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'El tamaño de la página debe ser un número positivo.'
        ], Response::HTTP_BAD_REQUEST);
    }

    // Iniciar la consulta
    $query = Autobus::query();

    // Aplicar filtro de búsqueda si existe
    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('Placa_', 'LIKE', "%{$keyword}%")
              ->orWhereHas('linea', function($q) use ($keyword) {
                  $q->where('nombreLinea', 'LIKE', "%{$keyword}%");
              })
              ->orWhereHas('propietario', function($q) use ($keyword) {
                  $q->where('CI_', 'LIKE', "%{$keyword}%")
                    ->orWhere('nombre', 'LIKE', "%{$keyword}%")
                    ->orWhere('apellido', 'LIKE', "%{$keyword}%");
              });
        });
    }

    // Obtener autobuses con sus relaciones
    $buses = $query->with(['linea', 'propietario', 'modelo.marca'])->paginate($pageSize, ['*'], 'page', $page);

    // Formatear los autobuses
    $busesFormatted = $buses->getCollection()->map(function ($bus) {
        return [
            'Placa_' => $bus->Placa_,
            'marca' => $bus->modelo && $bus->modelo->marca ? $bus->modelo->marca->nombre : 'Marca no disponible',
            'modelo' => $bus->modelo ? $bus->modelo->nombre : 'Modelo no disponible',
            'Linea_' => $bus->linea ? $bus->linea->Linea_ : 'Línea no disponible',
            'propietario' => $bus->propietario ? [
                'CI_' => $bus->propietario->CI_,
                'nombre' => $bus->propietario->nombre,
                'apellido' => $bus->propietario->apellido
            ] : null,
            'capacidad' => $bus->capacidad,
            'anio' => $bus->autobusesanio,
        ];
    });

    return response()->json([
        'data' => $busesFormatted,
        'pagination' => [
            'total' => $buses->total(),
            'per_page' => $buses->perPage(),
            'current_page' => $buses->currentPage(),
            'last_page' => $buses->lastPage(),
        ],
        'message' => 'Lista de autobuses',
        'status' => Response::HTTP_OK
    ], Response::HTTP_OK);
}



public function store(Request $request)
{
    try {
        // Registrar los datos recibidos para depuración
        \Log::info('Datos recibidos en la solicitud:', $request->all());

        // Extraer el objeto datosAutobus de la solicitud
        $datosAutobus = $request->input('datosAutobus');

        // Validar los datos entrantes
        $validatedData = \Validator::make($datosAutobus, [
            'Placa_' => 'required|string|max:15|unique:autobuses,Placa_',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'Linea_' => 'required|string',
            'propietario_CI_' => 'required|string|exists:usuarios,CI_',
            'capacidad' => 'required|integer',
            'autobusesanio' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'condicion' => 'required|string|in:activo,inactivo,reparacion',
        ])->validate();

        // Buscar la línea por nombre
        $linea = Linea::where('Linea_', $validatedData['Linea_'])->first();
        if (!$linea) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Línea no encontrada',
            ], 404);
        }

        // Buscar el propietario por su CI_
        $propietario = Usuario::where('CI_', $validatedData['propietario_CI_'])->first();
        if (!$propietario) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Propietario no encontrado',
            ], 404);
        }

        // Buscar o crear la marca
        $marca = Marca::firstOrCreate(['nombre' => $validatedData['marca']]);

        // Buscar o crear el modelo relacionado a la marca
        $modelo = Modelo::firstOrCreate([
            'nombre' => $validatedData['modelo'],
            'idMarca' => $marca->id,
        ]);

        // Buscar la condición en la tabla condicions
        $condicion = Condicion::where('condicion', $validatedData['condicion'])->firstOrFail();

        // Crear el autobús
        $autobus = Autobus::create([
            'Placa_' => $validatedData['Placa_'],
            'idLinea' => $linea->id,
            'idUsuario' => $propietario->id,
            'capacidad' => $validatedData['capacidad'],
            'idModelo' => $modelo->id,
            'autobusesanio' => $validatedData['autobusesanio'],
            'idCondicion' => $condicion->id, // Guardar el id de la condición
        ]);

        // Respuesta de éxito
        return response()->json([
            'error' => false,
            'mensaje' => 'Autobús creado con éxito',
            'data' => $autobus,
        ], 201);

    } catch (\Illuminate\Database\QueryException $e) {
        // Manejo específico para errores de la base de datos como clave única
        if ($e->getCode() === '23000') {
            return response()->json([
                'error' => true,
                'mensaje' => 'La placa ya está en uso',
            ], 409);
        }
        // Manejo general de errores de la base de datos
        return response()->json([
            'error' => true,
            'mensaje' => 'Error al crear el autobús',
            'exception' => $e->getMessage(),
        ], 500);
    } catch (ValidationException $e) {
        // Respuesta de error de validación
        return response()->json([
            'error' => true,
            'mensaje' => 'Datos de entrada no válidos',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Respuesta de error general
        return response()->json([
            'error' => true,
            'mensaje' => 'Error al crear el autobús',
            'exception' => $e->getMessage(),
        ], 500);
    }
}


    public function update(Request $request, Autobus $autobus)
    {
        try {
            $validatedData = $request->validate([
                'Placa_' => 'required|string|max:15|unique:autobuses,Placa_,' . $autobus->id,
                'idLinea' => 'required|exists:lineas,id',
                'idUsuario' => 'required|exists:usuarios,id',
                'capacidad' => 'required|integer',
                'idModelo' => 'required|exists:modelos,id',
                'idCondicion' => 'required|exists:condicions,id',
            ]);

            $autobus->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Autobús actualizado con éxito',
                'data' => $autobus,
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
                'mensaje' => 'Error al actualizar el autobús',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(Autobus $autobus)
    {
        try {
            $autobus->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Autobús eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el autobús',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
