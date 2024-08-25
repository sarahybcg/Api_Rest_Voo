<?php

namespace Database\Factories;

use App\Models\Propietario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

 
class PropietarioFactory extends Factory
{
    protected $model = Propietario::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::factory(),  
            'carnetCirculacion' => $this->faker->unique()->text(200),  
        ];
    }
}
