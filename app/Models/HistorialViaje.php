<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialViaje extends Model
{
    public $table= "historialViajes";

    protected $fillable =array("*");

    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class, 'idTrayecto');
    }

    public function autobus()
    {
        return $this->belongsTo(Autobus::class, 'idAutobus');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
      
}
