<?php

namespace Database\Seeders;

use App\Models\Prioridad;
use App\Models\Valoracion;
use App\Models\Notificacion;
use App\Models\Propietario;
use App\Models\Busqueda;
use App\Models\Condicion;
use App\Models\LineaTrayecto;
use App\Models\Modelo;
use App\Models\Marca;
use App\Models\Rol;
use App\Models\Comentario;
use App\Models\HistorialViaje;
use App\Models\Autobus;
use App\Models\Conductor;
use App\Models\Experiencia;
use App\Models\Linea;
use App\Models\Parada;
use App\Models\Trayecto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{ 
    public function run(): void
    {
        // Primero, crea registros en las tablas relacionadas
       /* Rol::factory()->count(4)->create();
        Usuario::factory()->count(10)->create();
        Propietario::factory()->count(10)->create();
        Conductor::factory()->count(10)->create();
        Prioridad::factory()->count(10)->create();
        Notificacion::factory()->count(10)->create();
        Valoracion::factory()->count(10)->create();
        Experiencia::factory()->count(10)->create();
        Comentario::factory()->count(10)->create();
        Linea::factory()->count(10)->create(); 
        Marca::factory()->count(10)->create();
        Modelo::factory()->count(10)->create();*/
        Condicion::factory()->count(10)->create();
       /* Parada::factory()->count(10)->create();
        Trayecto::factory()->count(10)->create();
        HistorialViaje::factory()->count(10)->create();
        // Luego, crea registros en las tablas dependientes
       Autobus::factory()->count(10)->create();
        Trayecto::factory()->count(10)->create();
        HistorialViaje::factory()->count(10)->create();
        Parada::factory()->count(10)->create();*/
    }
}
