<?php

namespace Database\Factories;

use App\Models\Linea;
use App\Models\Trayecto;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class LineaTrayectoFactory extends Factory
{
      
    public function definition(): array
    {
        return [
            'idLinea' => Linea::factory(),
            'idTrayecto' => Trayecto::factory(),
        ];
    }
}
