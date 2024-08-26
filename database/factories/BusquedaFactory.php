<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
 
use App\Models\Usuario;
 
class BusquedaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::inRandomOrder()->first()->id,  
            'consulta' => $this->faker->word,
            'fechaBusqueda' => $this->faker->date,
            'resultado' => $this->faker->text,
        ];
    }
}
