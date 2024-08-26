<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory; 
use App\Models\Usuario;
use App\Models\Prioridad;

class NotificacionFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'idUsuario' => Usuario::factory(),  
            'titulo' => $this->faker->sentence,  
            'descripcion' => $this->faker->paragraph,  
            'fechaEnvio' => $this->faker->dateTimeBetween('-1 month', 'now'),  
            'idPrioridad' => Prioridad::factory(), 
        ]; 
    }
}
