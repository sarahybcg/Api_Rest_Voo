<?php

namespace Database\Factories;

use App\Models\Linea;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class LineaFactory extends Factory
{
    protected $model = Linea::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'Linea_' => strtoupper($this->faker->unique()->bothify('Linea-###')),  
            'idUsuario' => Usuario::factory(),  
        ];
    }
}
