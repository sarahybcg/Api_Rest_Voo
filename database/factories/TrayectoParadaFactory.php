<?php

namespace Database\Factories;

use App\Models\Trayecto;
use App\Models\Parada;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class TrayectoParadaFactory extends Factory
{
     
    public function definition(): array
    {
        return[
            'trayecto_id' => Trayecto::inRandomOrder()->first()->id,  
            'parada_id' => Parada::inRandomOrder()->first()->id, 
        ];
    }
}
