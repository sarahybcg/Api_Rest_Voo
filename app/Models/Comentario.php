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

  //METODO NUEVO
     public static function searchAndPaginate($keyword = null, $perPage = 10)
     {
         $query = self::query()->latest('created_at');
 
         if ($keyword) {
             $query->where(function ($q) use ($keyword) {
                 $q->where('comentario', 'like', "%{$keyword}%");
             });
         }
         return $query->paginate($perPage);
     }
}
