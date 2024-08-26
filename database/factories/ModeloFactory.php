<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class ModeloFactory extends Factory
{ 
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word, 
            'idMarca' => Marca::factory(),
        ];
    }
}
