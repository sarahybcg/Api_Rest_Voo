<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class ModeloFactory extends Factory
{
    protected $model = \App\Models\Modelo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,  
            'idMarca' => Marca::inRandomOrder()->first()->id, 
        ];
    }
}
