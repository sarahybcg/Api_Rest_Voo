<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    public $table= "propietarios";

    protected $fillable=[
        'idUsuario',
        'carnetCirculacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
    
    public function autobus()
    {
        return $this->hasMany(Autobus::class, 'idUsuario');
    }
}
