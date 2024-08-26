<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;

 
class ParadaFactory extends Factory
{ 
    public function definition(): array
    {
        return [
                'nombre' => $this->faker->unique()->word,  
                'descripcion' => $this->faker->optional()->paragraph,  
                'latitud' => $this->faker->latitude(-90, 90),  
                'longitud' => $this->faker->longitude(-180, 180), 
        ];
    }
}
