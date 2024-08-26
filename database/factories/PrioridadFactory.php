<?php

namespace Database\Factories;

 
use Illuminate\Database\Eloquent\Factories\Factory;
 
class PrioridadFactory extends Factory
{ 
    public function definition(): array
    {
        return [
            'nombrePrioridad' => $this->faker->word,  
        ];
    }
}
