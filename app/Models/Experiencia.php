<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    use HasFactory;


    public $table = "experiencias";

    protected $fillable = [
        'idUsuario',
        'idValoracion',
        'fechaEnvio',
    ];

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

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
  //METODO NUEVO
    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        $query = self::with(['usuario', 'valoracion'])->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('usuario', function ($q) use ($keyword) {
                    $q->where('nombre', 'like', "%{$keyword}%")
                        ->orWhere('apellido', 'like', "%{$keyword}%")
                        ->orWhere('CI_', 'like', "%{$keyword}%")
                        ->orWhere('telefono_', 'like', "%{$keyword}%");
                })->orWhere('fechaEnvio', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }
}
