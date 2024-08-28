<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autobus extends Model
{
    use HasFactory;

    public $table= "autobuses";

    protected $fillable =[
        'Placa_',
        'idLinea',
        'idUsuario',
        'capacidad',
        'idModelo',
        'idCondicion',
    ];

    
 
    public function linea()
    {
        return $this->belongsTo(Linea::class, 'idLinea');
    }
 
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'idUsuario');
    }
 
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'idModelo');
    }
  
    public function condicion()
    {
        return $this->belongsTo(Condicion::class, 'idCondicion');
    }
       
    public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idAutobus');
    }
}
