<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialViaje extends Model
{
    use HasFactory;
    public $table= "historial_viajes";

    protected $fillable =[
        'idTrayecto',
        'idAutobus',
        'idUsuario',
        'tiempo_inicio',
        'tiempo_fin', 
        'estado',
    ];

    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class, 'idTrayecto');
    }

    public function autobus()
    {
        return $this->belongsTo(Autobus::class, 'idAutobus');
    }

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'idUsuario');
    }
      
}
