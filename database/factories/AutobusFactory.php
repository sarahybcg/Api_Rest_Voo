<?php

namespace Database\Factories;

 
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Modelo;
use App\Models\Condicion;
use App\Models\Usuario;
use App\Models\Linea;  
use App\Models\Conductor;  

class AutobusFactory extends Factory
{ 
    public function definition()
    {
        return [
           'Placa_' => $this->faker->unique()->word,
            'idLinea' => Linea::factory(),  
            'idUsuario' =>  Conductor::factory(),  
            'capacidad' => $this->faker->numberBetween(10, 50),
            'idModelo' =>  Modelo::factory(),  
            'idCondicion' => Condicion::factory(),
            'created_at' => now(),
            'updated_at' => now(), 
        ];
    }
}
