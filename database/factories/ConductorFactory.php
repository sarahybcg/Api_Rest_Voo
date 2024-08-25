<?php

namespace Database\Factories;

use App\Models\Conductor;
use App\Models\Propietario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conductor>
 */
class ConductorFactory extends Factory
{
    protected $model = Conductor::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'idUsuario' => Usuario::factory(),  
            'licenciaConduccion' => $this->faker->unique()->text(200),  
        ];
    }
}
