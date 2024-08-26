<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rol;

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
            'clave' => $this->faker->password,
            'idRol' => Rol::factory(),
        ];
    }
}
