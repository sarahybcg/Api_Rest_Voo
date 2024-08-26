<?php

namespace Database\Factories;

 
use App\Models\Experiencia;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class ComentarioFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comentario' => $this->faker->paragraph,
            'idExperiencia' => Experiencia::factory(),   
        ];
    }
}
