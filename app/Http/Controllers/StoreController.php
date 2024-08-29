<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AutobusController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\ParadaController;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->json()->all();
        
        // Dividir datos principales y adicionales
        $datosPrincipales = $data['datosPrincipales'];
        $datosAdicionales = $data['datosAdicionales'];
        
        // Enviar datos principales al controlador de Usuario
        $usuarioController = app(UsuarioController::class);
        $usuarioController->store(new Request($datosPrincipales));
        
        // Enviar datos adicionales al controlador de Autobus, Linea o Parada según corresponda
        if (isset($datosAdicionales['Linea_'])) {
            $lineaController = app(LineaController::class);
            $lineaController->store(new Request($datosAdicionales));
        }

        // Otros envíos según los datos adicionales
        // ...

        return response()->json(['message' => 'Registro completado correctamente.']);
    }
}