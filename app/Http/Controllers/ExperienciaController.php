<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ExperienciaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $experiencias = Experiencia::searchAndPaginate($keyword, 10);
 
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
                    'telefono_' => $experiencia->usuario->telefono_,
                    'fechaEnvio' => $experiencia->fechaEnvio,
                    'estrellas' => $experiencia->valoracion->estrellas
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
                'idValoracion' => 'required|exists:valoracions,id',
                'fechaEnvio' => 'required|date_format:Y-m-d H:i:s',
            ]);

            $experiencia = Experiencia::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Experiencia creada con éxito',
                'data' => $experiencia,
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
                'mensaje' => 'Error al crear la experiencia',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Experiencia $experiencia)
    {
        return response()->json([
            'error' => false,
            'data' => $experiencia->load(['usuario', 'valoracion']),
        ], 200);
    }

    public function update(Request $request, Experiencia $experiencia)
    {

        try {
            $validatedData = $request->validate([
                'idUsuario' => 'required|exists:usuarios,id',
                'idValoracion' => 'required|exists:valoracions,id',
                'fechaEnvio' => 'required|date_format:Y-m-d H:i:s',
            ]);

            $experiencia->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Experiencia actualizada con éxito',
                'data' => $experiencia,
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
                'mensaje' => 'Error al actualizar la experiencia',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Experiencia $experiencia)
    {
        try {
            $experiencia->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Experiencia eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la experiencia',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
