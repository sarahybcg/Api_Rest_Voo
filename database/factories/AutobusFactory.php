<?php

namespace Database\Factories;

use App\Models\Autobus;
use App\Models\Linea;
use App\Models\Usuario;
use App\Models\Modelo;
use App\Models\Condicion;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class AutobusFactory extends Factory
{
    protected $model = Autobus::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Placa_' => strtoupper($this->faker->bothify('???-####')),  
            'idLinea' => Linea::factory(),   
            'idUsuario' => Usuario::factory(),  
            'capacidad' => $this->faker->numberBetween(30, 60),   
            'idModelo' => Modelo::factory(),  
            'idCondicion' => Condicion::factory(),   
        ];
    }
}
