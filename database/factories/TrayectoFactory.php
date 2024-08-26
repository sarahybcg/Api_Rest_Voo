<?php

namespace Database\Factories;

 
use Illuminate\Database\Eloquent\Factories\Factory;

 
class TrayectoFactory extends Factory
{ 
    public function definition(): array
    {
        return [
            'nombre_trayecto' => $this->faker->word,
            'descripcion' => $this->faker->paragraph,
            'origen' => $this->faker->city,
            'destino' => $this->faker->city,
            'distancia' => $this->faker->optional()->randomFloat(2, 0, 1000), 
        ];
    }
}
