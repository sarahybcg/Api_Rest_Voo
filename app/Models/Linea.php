<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;

    public $table= "lineas";
    protected $fillable = [
        'Linea_',
        'Rif_',
        'idUsuario_admin',
        'Dir_Oficina',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario_admin'); 
    }
    public function autobuses()
    {
        return $this->hasMany(Autobus::class, 'idLinea');
    }
    public function trayectos()
    {
        return $this->belongsToMany(Trayecto::class, 'linea_trayectos', 'idLinea', 'idTrayecto');
    }
     
}
