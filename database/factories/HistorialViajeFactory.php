<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HistorialViaje;
use App\Models\Trayecto;
use App\Models\Autobus;
use App\Models\Usuario;

 
class HistorialViajeFactory extends Factory
{
    
    public function definition(): array
    {  

        return [
            'idTrayecto' => Trayecto::factory(),   
            'idAutobus' => Autobus::factory(),     
            'idUsuario' => Usuario::factory(),    
            'tiempo_inicio' => $this->faker->dateTimeBetween('-1 month', 'now'),  
            'tiempo_fin' => $this->faker->dateTimeBetween('now', '+1 month'),    
            'estado' => $this->faker->randomElement(['en progreso', 'completado', 'cancelado']),  

        ];
    }
}
