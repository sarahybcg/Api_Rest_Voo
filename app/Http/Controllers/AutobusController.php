<?php

namespace App\Http\Controllers;

use App\Models\Autobus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class AutobusController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $autobuses = Autobus::searchAndPaginate($keyword, 10);
 
        if ($autobuses->total() === 0) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Autobús no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } 
  
        
        return response()->json([
            'data' => array_map(function ($autobus) {
                return [
                    'Placa' => $autobus->Placa_,
                    'Linea' => $autobus->linea->nombre,
                    'Capacidad' => $autobus->capacidad,
                    'Modelo' => $autobus->modelo->nombre,
                    'Marca' => $autobus->modelo->marca->nombre,
                ];
            }, $autobuses->items()),
            'pagination' => [
                'total' => $autobuses->total(),
                'per_page' => $autobuses->perPage(),
                'current_page' => $autobuses->currentPage(),
                'last_page' => $autobuses->lastPage(),
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
