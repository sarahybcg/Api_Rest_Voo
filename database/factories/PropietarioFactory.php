<?php

namespace Database\Factories;

use App\Models\Propietario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class PropietarioFactory extends Factory
{ 
    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::factory(),  
            'carnetCirculacion' => $this->faker->text(200),  
        ];
    }
}
