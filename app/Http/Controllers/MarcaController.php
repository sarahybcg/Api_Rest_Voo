<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class MarcaController extends Controller
{
//CAMBIO EN EL INDEX
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $marcas = Marca::searchAndPaginate($keyword, 10);

        if ($marcas->total() === 0) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Marca no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => array_map(function ($marcas) {
                return [
                    'nombre_trayecto' => $marcas->nombre_trayecto
                ];
            }, $marcas->items()),
            'pagination' => [
                'total' => $marcas->total(),
                'per_page' => $marcas->perPage(),
                'current_page' => $marcas->currentPage(),
                'last_page' => $marcas->lastPage(),
            ],
            'message' => 'Lista de marcas',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
            ]);

            $marca = Marca::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca creada con éxito',
                'data' => $marca,
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
                'mensaje' => 'Error al crear la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Marca $marca)
    {
        return response()->json([
            'error' => false,
            'data' => $marca,
        ], 200);
    }

    public function update(Request $request, Marca $marca)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:80',
            ]);

            $marca->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca actualizada con éxito',
                'data' => $marca,
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
                'mensaje' => 'Error al actualizar la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Marca $marca)
    {
        try {
            $marca->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Marca eliminada con éxito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar la marca',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
