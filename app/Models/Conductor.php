<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    public $table= "conductors";

    protected $fillable=[
        'idUsuario',
        'licenciaConducir',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idUsuario');
    }

    public function autobus()
    {
        return $this->hasMany(Autobus::class, 'idUsuario');
    }
}
