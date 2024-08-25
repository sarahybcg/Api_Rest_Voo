<?php

namespace Database\Factories;

use App\Models\Trayecto;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class TrayectoFactory extends Factory
{
    protected $model = Trayecto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_trayecto' => $this->faker->word(),  
            'descripcion'     => $this->faker->sentence(), 
            'origen'          => $this->faker->city(),  
            'destino'         => $this->faker->city(),  
            'distancia'       => $this->faker->randomFloat(2, 1, 1000),  
        ];
    }
}
