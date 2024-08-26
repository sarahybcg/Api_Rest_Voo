<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class RolFactory extends Factory
{
     
    public function definition(): array
    {
        return [
            'nombreRol' => $this->faker->unique()->word(),  
        ];
    }
}
