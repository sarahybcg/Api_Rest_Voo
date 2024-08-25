<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Busqueda;
use App\Models\Usuario;
 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Busqueda>
 */
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
            'idUsuario' => Usuario::inRandomOrder()->first()->id, // Asumiendo que ya tienes usuarios en la base de datos
            'consulta' => $this->faker->word,
            'fechaBusqueda' => $this->faker->date,
            'resultado' => $this->faker->text,
        ];
    }
}
