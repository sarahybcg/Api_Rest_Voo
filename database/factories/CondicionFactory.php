<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Condicion;

class CondicionFactory extends Factory
{
    protected $model = Condicion::class;
    public function definition(): array
    {
        return [
           'condicion' => $this->faker->word, // Genera una palabra aleatoria
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
