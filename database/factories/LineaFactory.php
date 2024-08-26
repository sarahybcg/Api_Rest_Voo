<?php

namespace Database\Factories;
 
use App\Models\Usuario;use App\Models\Linea;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class LineaFactory extends Factory
{  protected $model = Linea::class;
    public function definition(): array
    {
        
        return [
            'Linea_' => $this->faker->unique()->word,
            'idUsuario' => Usuario::factory(),
        ];
    }
}
