<?php

namespace Database\Factories;

use App\Models\HistorialViaje;
use App\Models\Trayecto;
use App\Models\Autobus;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class HistorialViajeFactory extends Factory
{
    protected $model = HistorialViaje::class;
    
    public function definition(): array
    {  

        return [
            'idTrayecto' => Trayecto::factory(),   
            'idAutobus' => Autobus::factory(),     
            'idUsuario' => Usuario::factory(),    
            'tiempo_inicio' => $this->faker->dateTimeBetween('-1 month', 'now'),  
            'tiempo_fin' => $this->faker->dateTimeBetween('now', '+1 month'),    
            'duracion' => $this->faker->time(),  
            'estado' => $this->faker->randomElement(['en progreso', 'completado', 'cancelado']),  

        ];
    }
}
