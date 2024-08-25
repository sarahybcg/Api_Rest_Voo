<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    public $table= "conductors";

    protected $fillable=array("*");

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
}
