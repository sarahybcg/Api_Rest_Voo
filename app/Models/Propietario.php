<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    public $table= "propietarios";

    protected $fillable=array("*");

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
}
