<?php

namespace Database\Factories;

use App\Models\Parada;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class ParadaFactory extends Factory
{
    protected $model = Parada::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'      => $this->faker->streetName(),  
            'descripcion' => $this->faker->sentence(),  
            'latitud'     => $this->faker->latitude(-90, 90),  
            'longitud'    => $this->faker->longitude(-180, 180),  
        ];
    }
}
