<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    public $table= "modelos";

    protected $fillable=[
        'nombre',
        'idMarca',
    ];

 //modelo pertenece a una marc

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'idMarca');
    }
     
    public function autobuses()
    {
        return $this->hasMany(Autobus::class, 'idModelo');
    }
}
