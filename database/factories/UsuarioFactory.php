<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
 
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'CI_' => $this->faker->unique()->bothify('##########'),  
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'telefono_' => $this->faker->phoneNumber(),
            'fechaNacimiento' => $this->faker->date(),
            'clave' => $this->faker->password(), 
            'idRol' => \App\Models\Rol::factory(), 
        ];
    }
}
