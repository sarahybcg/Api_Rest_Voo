<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Linea;
use App\Models\Rol;
use App\Models\Conductor;
use App\Models\RolUsuario; // Modelo para la tabla pivot
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Dividir datos principales y adicionales
        $datosPrincipales = $data['datosPrincipales'] ?? [];
        $datosAdicionales = $data['datosAdicionales'] ?? [];
        $rolNombre = $datosPrincipales['role'] ?? null;
        Log::info('Datos recibidos:', $datosPrincipales);
        

        $response = ['message' => 'Registro completado correctamente.'];
        $statusCode = 200;

        try {
            // Enviar datos principales al controlador de Usuario
            $usuarioController = app(UsuarioController::class);
            $usuarioResponse = $usuarioController->store(new Request($datosPrincipales));
            $usuarioData = json_decode($usuarioResponse->getContent(), true);

            if ($usuarioResponse->status() !== 201) {
                return response()->json([
                    'message' => 'Error al registrar usuario: ' . $usuarioResponse->getContent()
                ], $usuarioResponse->status());
            }

            // Mapear CI_ a id
            $idUsuario = $usuarioData['data']['id'] ?? null;

            if (!$idUsuario) {
                return response()->json([
                    'message' => 'ID de usuario no encontrado en la respuesta.'
                ], 500);
            }

            if ($rolNombre) {
                // Buscar el rol por nombre
                $rol = Rol::where('nombreRol', $rolNombre)->first();
    
                if ($rol) {
                    // Guardar el rol en la tabla pivot rol_usuarios
                    RolUsuario::create([
                        'usuario_id' => $idUsuario,
                        'rol_id' => $rol->id,
                    ]);
                } else {
                    return response()->json([
                        'message' => "Rol no encontrado: $rolNombre"
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => "No se ha proporcionado un rol."
                ], 400);
            }
    
            

            // Enviar datos adicionales al controlador de Linea si existe Linea_
            if (isset($datosAdicionales['Linea_'])) {
                $datosAdicionales['idUsuario_admin'] = $idUsuario; // Mapear CI_ a idUsuario_admin
                $lineaController = app(LineaController::class);
                $lineaResponse = $lineaController->store(new Request($datosAdicionales));

                if ($lineaResponse->status() !== 201) {
                    return response()->json([
                        'message' => 'Error al registrar línea: ' . $lineaResponse->getContent()
                    ], $lineaResponse->status());
                }
            }

            // Enviar datos adicionales al controlador de Conductor si existe licenciaConducir
            if (isset($datosAdicionales['licenciaConducir'])) {
                $datosAdicionales['idUsuario'] = $idUsuario; // Mapear CI_ a idUsuario
                $conductorController = app(ConductorController::class);
                $conductorResponse = $conductorController->store(new Request($datosAdicionales));

                if ($conductorResponse->status() !== 201) {
                    return response()->json([
                        'message' => 'Error al registrar conductor: ' . $conductorResponse->getContent()
                    ], $conductorResponse->status());
                }
            }
            
        } catch (ValidationException $e) {
            // Si ocurre un error de validación, devolver el código de estado de la excepción
            return response()->json([
                'message' => $e->errors()
            ], 422); // Código 422 para errores de validación
        } catch (\Exception $e) {
            // Para otros errores que no sean de validación, devolver un error 500
            $response = ['message' => 'Error en el servidor: ' . $e->getMessage()];
            $statusCode = 500;
        }

        return response()->json($response, $statusCode);
    }
}
 