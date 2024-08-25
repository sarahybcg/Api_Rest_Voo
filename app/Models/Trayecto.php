<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayecto extends Model
{
    use HasFactory;

    public $table= "trayectos";
    
    protected $fillable=array("*");  

    public function lineas()
    {
        return $this->belongsToMany(Linea::class, 'linea_trayectos', 'idTrayecto', 'idLinea');
    }
 
    public function paradas()
    {
        return $this->belongsToMany(Parada::class, 'trayecto_paradas', 'trayecto_id', 'parada_id');
    }

       public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idTrayecto');
    }
}
