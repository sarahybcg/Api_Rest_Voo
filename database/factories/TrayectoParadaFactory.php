<?php

namespace Database\Factories;

use App\Models\Trayecto;
use App\Models\Parada;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class TrayectoParadaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return[
            'trayecto_id' => Trayecto::inRandomOrder()->first()->id,  
            'parada_id' => Parada::inRandomOrder()->first()->id, 
        ];
    }
}
