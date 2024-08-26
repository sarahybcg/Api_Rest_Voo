<?php

namespace Database\Factories;

 
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class ConductorFactory extends Factory
{
     
    public function definition(): array
    {
        return [
           'idUsuario' => Usuario::factory(),  
            'licenciaConducir' => $this->faker->text(200),  
        ];
    }
}
