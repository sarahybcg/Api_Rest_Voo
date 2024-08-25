<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
    use HasFactory;

    public $table= "busquedas";

    protected $fillable=array("*");
 
    //hasMany para indicar que una Busqueda puede estar asociada con varios usuarios.
    public function busqueda()
    {
    return $this->hasMany(Busqueda::class, 'idUsuario');  
    }
}
