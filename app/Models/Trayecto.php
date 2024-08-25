<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayecto extends Model
{
    use HasFactory;

    public $table= "trayectos";
    
    protected $fillable=array("*");  

       public function parada()
       {
           return $this->belongsToMany(Parada::class, 'trayecto_paradas');  
       }

       public function linea()
       {
           return $this->belongsToMany(Linea::class, 'linea_trayecto');  
       }

       public function historialViajes()
     {
        return $this->hasMany(HistorialViaje::class, 'idTrayecto');
     }
}
