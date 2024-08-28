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
        Usuario::factory()->count(10)->create();
      
}
}
