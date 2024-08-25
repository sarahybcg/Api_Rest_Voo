<?php

namespace Database\Factories;

use App\Models\HistorialViaje;
use App\Models\Trayecto;
use App\Models\Autobus;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialViaje>
 */
class HistorialViajeFactory extends Factory
{
    protected $model = HistorialViaje::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $tiempo_inicio = Carbon::now()->subDays(rand(1, 30));
         
        $tiempo_fin = (clone $tiempo_inicio)->addHours(rand(1, 5))->addMinutes(rand(0, 59));

        return [
            'idTrayecto' => Trayecto::factory(),   
            'idAutobus' => Autobus::factory(),     
            'idUsuario' => Usuario::factory(),    
            'tiempo_inicio' => $tiempo_inicio,
            'tiempo_fin' => $tiempo_fin,
            'duracion' => $tiempo_fin->diff($tiempo_inicio)->format('%H:%I:%S'), 
            'estado' => $this->faker->randomElement(['en progreso', 'finalizado']),   
        ];
    }
}
