<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class BusquedaController extends Controller
{
//CAMBIO EN EL INDEX
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $experiencias = Busqueda::searchAndPaginate($keyword, 10);
 
        if ($experiencias->total() === 0) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Experiencia no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }
 
        return response()->json([
            'data' => array_map(function ($experiencia) {
                return [
                    'CI_' => $experiencia->usuario->CI_,
                    'nombre' => $experiencia->usuario->nombre,
                    'apellido' => $experiencia->usuario->apellido,
                    'consulta' => $experiencia->consulta, 
                    'resultado' => $experiencia->resultado, 
                    'fechaBusqueda' => $experiencia->fechaBusqueda
                ];
            }, $experiencias->items()),
            'pagination' => [
                'total' => $experiencias->total(),
                'per_page' => $experiencias->perPage(),
                'current_page' => $experiencias->currentPage(),
                'last_page' => $experiencias->lastPage(),
            ],
            'message' => 'Lista de experiencias',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'consulta' => 'required|string|max:50',
                'fechaBusqueda' => 'nullable|date',
                'resultado' => 'nullable|string',
            ]);

            $busqueda = Busqueda::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda creada con éxito',
                'data' => $busqueda,
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
                'mensaje' => 'Error al crear la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Busqueda $busqueda)
    {
        return response()->json([
            'error' => false,
            'data' => $busqueda,
        ], 200);
    }

    
    public function update(Request $request, Busqueda $busqueda)
    {
        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'consulta' => 'required|string|max:50',
                'fechaBusqueda' => 'nullable|date',
                'resultado' => 'nullable|string',
            ]);

            $busqueda->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda actualizada con éxito',
                'data' => $busqueda,
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
                'mensaje' => 'Error al actualizar la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    
    public function destroy(Busqueda $busqueda)
    {
        try {
            $busqueda->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Búsqueda eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la búsqueda',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
