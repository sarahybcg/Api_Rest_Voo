<?php

namespace Database\Factories;

use App\Models\Prioridad;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class PrioridadFactory extends Factory
{
    protected $model = Prioridad::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombrePrioridad' => $this->faker->word(),  
        ];
    }
}
