<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
     
    public function definition(): array
    { 
        return [
            'CI_' => '1234567890', // Puedes personalizar estos valores para la prueba
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'telefono_' => '0987654321',
            'fechaNacimiento' => '1990-01-01',
            'clave' => Hash::make('password123')
        ];
    }
}
