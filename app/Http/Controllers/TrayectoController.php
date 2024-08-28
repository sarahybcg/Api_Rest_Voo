<?php

namespace App\Http\Controllers;

use App\Models\Trayecto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class TrayectoController extends Controller
{ 
    //CAMBIO EN EL INDEX
    public function index(Request $request)
    {
        $keyword = $request->input('search');   
        $trayectos = Trayecto::searchAndPaginate($keyword, 10);
 
        if ($trayectos->total() === 0) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Trayecto no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
 
        return response()->json([
            'data' => array_map(function ($trayectos) {
                return [
                    'nombre_trayecto' => $trayectos->nombre_trayecto,
                    'descripcion' => $trayectos->descripcion,
                    'origen' => $trayectos->origen,
                    'destino' => $trayectos->destino,
                    'distancia' => $trayectos->distancia
                ];
            }, $trayectos->items()),
            'pagination' => [
                'total' => $trayectos->total(),
                'per_page' => $trayectos->perPage(),
                'current_page' => $trayectos->currentPage(),
                'last_page' => $trayectos->lastPage(),
            ],
            'message' => 'Lista de trayectos',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

 
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_trayecto' => 'nullable|string|max:80',
                'descripcion' => 'required|string',
                'origen' => 'required|string|max:255',
                'destino' => 'required|string|max:255',
                'distancia' => 'nullable|numeric|min:0',
            ]);

            $trayecto = Trayecto::create($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto creado con éxito',
                'data' => $trayecto,
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
                'mensaje' => 'Error al crear el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function show(Trayecto $trayecto)
    {
        return response()->json([
            'error' => false,
            'data' => $trayecto,
        ], 200);
    }
 
    public function update(Request $request, Trayecto $trayecto)
    {
        try {
            $validatedData = $request->validate([
                'nombre_trayecto' => 'nullable|string|max:80',
                'descripcion' => 'required|string',
                'origen' => 'required|string|max:255',
                'destino' => 'required|string|max:255',
                'distancia' => 'nullable|numeric|min:0',
            ]);

            $trayecto->update($validatedData);

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto actualizado con éxito',
                'data' => $trayecto,
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
                'mensaje' => 'Error al actualizar el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function destroy(Trayecto $trayecto)
    {
        try {
            $trayecto->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Trayecto eliminado con éxito',
            ], 200);
        } catch (\Exception $e) {
            
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al eliminar el trayecto',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
