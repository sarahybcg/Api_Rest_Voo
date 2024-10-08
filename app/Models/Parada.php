<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parada extends Model
{
    use HasFactory;

    public $table= "paradas";
    
    protected $fillable= [
        'nombre',
        'descripcion',
        'latitud',
        'longitud',
    ];
    
    public function trayectos()
    {
        return $this->belongsToMany(Trayecto::class, 'trayecto_paradas', 'parada_id', 'trayecto_id');
    }
}
