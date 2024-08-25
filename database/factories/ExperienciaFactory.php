<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notificacion;
use App\Models\Usuario;
use App\Models\Prioridad;
 

 
class ExperienciaFactory extends Factory
{
    protected $model = Notificacion::class;
    
    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::factory(), // Relación con el modelo Usuario
            'titulo' => $this->faker->sentence(5), // Genera un título de 5 palabras
            'descripcion' => $this->faker->paragraph(), // Genera una descripción aleatoria
            'fechaEnvio' => $this->faker->dateTime(), // Genera una fecha y hora aleatoria
            'idPrioridad' => Prioridad::factory(), // Relación con el modelo Prioridad
        ];

    }
}
