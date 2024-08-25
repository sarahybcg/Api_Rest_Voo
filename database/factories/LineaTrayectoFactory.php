<?php

namespace Database\Factories;

use App\Models\Linea;
use App\Models\Trayecto;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class LineaTrayectoFactory extends Factory
{
     
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idLinea' => Linea::factory(),
            'idTrayecto' => Trayecto::factory(),
        ];
    }
}
