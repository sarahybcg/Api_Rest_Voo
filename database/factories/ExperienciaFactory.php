<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notificacion;
use App\Models\Usuario;
use App\Models\Prioridad;
use App\Models\Valoracion;

class ExperienciaFactory extends Factory
{

    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::factory(),  
            'idValoracion' => Valoracion::factory(),    
            'fechaEnvio' => $this->faker->dateTime(),  
        ];

    }
}
