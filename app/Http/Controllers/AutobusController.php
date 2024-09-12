<?php

namespace App\Http\Controllers;

use App\Models\Autobus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class AutobusController extends Controller
{

    //CAMBIO EN EL INDEX
    public function index(Request $request)
{
    // Obtener palabra clave de búsqueda, página y tamaño de página
    $keyword = $request->input('search');
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
    $query = Bus::query();

    // Aplicar filtro de búsqueda si existe
    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('placa', 'LIKE', "%{$keyword}%")
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

    // Obtener autobuses con sus líneas y propietarios
    $buses = $query->with(['linea', 'propietario'])->paginate($pageSize, ['*'], 'page', $page);

    // Si no hay autobuses, retorna un mensaje de error
    if ($buses->isEmpty()) {
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'Autobús no encontrado'
        ], Response::HTTP_NOT_FOUND);
    }

    // Formatear los autobuses con sus líneas y propietarios
    $busesFormatted = $buses->getCollection()->map(function ($bus) {
        return [
            'Placa_' => $bus->placa,
            'marca' => $bus->marca,
            'modelo' => $bus->modelo,
            'Linea_' => $bus->linea ? $bus->linea->nombreLinea : null, // Nombre de la línea
            'propietario' => $bus->propietario ? [
                'CI_' => $bus->propietario->CI_,
                'nombre' => $bus->propietario->nombre,
                'apellido' => $bus->propietario->apellido
            ] : null, // Datos del propietario
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
            $validatedData = $request->validate([
                'Placa_' => 'required|string|max:15|unique:autobuses,Placa_',
                'idLinea' => 'required|exists:lineas,id',
                'idUsuario' => 'required|exists:usuarios,id',
                'capacidad' => 'required|integer',
                'idModelo' => 'required|exists:modelos,id',
                'idCondicion' => 'required|exists:condicions,id',
            ]);

            $autobus = Autobus::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Autobús creado con éxito',
                'data' => $autobus,
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
                'mensaje' => 'Error al crear el autobús',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }


    public function show(Autobus $autobus)
    {
        $autobus->load(['linea', 'usuario', 'modelo', 'condicion']);

        return response()->json([
            'error' => false,
            'data' => $autobus,
        ], 200);
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
