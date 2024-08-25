<?php

namespace Database\Factories;

use App\Models\Valoracion;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class ValoracionFactory extends Factory
{
    protected $model = Valoracion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estrellas' => $this->faker->numberBetween(1, 5), // Genera un número aleatorio entre 1 y 5
        ];
    }
}
