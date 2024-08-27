<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    public $table= "comentarios";

    protected $fillable=[
        'comentario',
        'idExperiencia',
    ];

     //belongsTo para indicar que la expe pertenece a un coment.
     public function experiencia()
     {
         return $this->belongsTo(Experiencia::class, 'idExperiencia');  
     }

}
