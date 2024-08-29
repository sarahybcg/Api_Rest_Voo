<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Linea;
use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Dividir datos principales y adicionales
        $datosPrincipales = $data['datosPrincipales'] ?? [];
        $datosAdicionales = $data['datosAdicionales'] ?? [];
        
        $response = ['message' => 'Registro completado correctamente.'];
        $statusCode = 200;

        try {
            // Enviar datos principales al controlador de Usuario
            $usuarioController = app(UsuarioController::class);
            $usuarioResponse = $usuarioController->store(new Request($datosPrincipales));
            $usuarioData = json_decode($usuarioResponse->getContent(), true);

            if ($usuarioResponse->status() !== 201) {
                throw new \Exception('Error al registrar usuario: ' . $usuarioResponse->getContent());
            }

            // Mapear CI_ a id
            $idUsuario = $usuarioData['data']['id'] ?? null;

            if (!$idUsuario) {
                throw new \Exception('ID de usuario no encontrado en la respuesta.');
            }

            // Enviar datos adicionales al controlador de Linea si existe Linea_
            if (isset($datosAdicionales['Linea_'])) {
                $datosAdicionales['idUsuario_admin'] = $idUsuario; // Mapear CI_ a idUsuario_admin
                $lineaController = app(LineaController::class);
                $lineaResponse = $lineaController->store(new Request($datosAdicionales));

                if ($lineaResponse->status() !== 201) {
                    throw new \Exception('Error al registrar línea: ' . $lineaResponse->getContent());
                }
            }

            // Enviar datos adicionales al controlador de Conductor si existe licenciaConducir
            if (isset($datosAdicionales['licenciaConducir'])) {
                $datosAdicionales['idUsuario'] = $idUsuario; // Mapear CI_ a idUsuario
                $conductorController = app(ConductorController::class);
                $conductorResponse = $conductorController->store(new Request($datosAdicionales));

                if ($conductorResponse->status() !== 201) {
                    throw new \Exception('Error al registrar conductor: ' . $conductorResponse->getContent());
                }
            }
            
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $statusCode = 500;
        }

        return response()->json($response, $statusCode);
    }
}