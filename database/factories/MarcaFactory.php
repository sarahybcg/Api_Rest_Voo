<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class MarcaFactory extends Factory
{
    protected $model = \App\Models\Marca::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,  
        ];
    }
}
