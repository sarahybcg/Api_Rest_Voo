<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    use HasFactory;


    public $table= "experiencias";

    protected $fillable=array("*");
 //hasMany para indicar que una experiencia puede estar asociado con varios comentarios.
    public function comentario()
    {
        return $this->hasMany(Comentario::class, 'idExperiencia');  
    }

    //experiencia está asociada a una sola valoración.
    public function valoracion()
    {
        return $this->belongsTo(Valoracion::class, 'idValoracion');
    }
}
