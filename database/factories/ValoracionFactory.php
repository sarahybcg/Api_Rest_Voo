<?php

namespace Database\Factories;

 
use Illuminate\Database\Eloquent\Factories\Factory;
 
class ValoracionFactory extends Factory
{
     
    public function definition(): array
    {
        return [
            'estrellas' => $this->faker->numberBetween(1, 5), 
        ];
    }
}
