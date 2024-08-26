<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public $table= "marcas";

    protected $fillable=[
        'nombre',
    ];

 //hasMany para indicar que un marc puede estar asociado con varios modelos.

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'idMarca');
    }
}
