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
            'CI_' => $this->faker->unique()->numerify('##########'),
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'telefono_' => $this->faker->numerify('##########'), // Ajustado para 10 dígitos
            'fechaNacimiento' => $this->faker->date(),
            'clave' => Hash::make($this->faker->password)
        ];
    }
}
