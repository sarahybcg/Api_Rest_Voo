<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    public $table= "rols";

    protected $fillable=array("*");
 //hasMany para indicar que un rol puede estar asociado con varios usuarios.
    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'idRol');  
    }
}
