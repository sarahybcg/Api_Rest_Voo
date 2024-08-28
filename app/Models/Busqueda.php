<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
    use HasFactory;

    public $table= "busquedas";

    protected $fillable=[
        'idUsuario',
        'consulta',
        'fechaBusqueda',
        'resultado',
    ];
 
    //hasMany para indicar que una Busqueda puede estar asociada con varios usuarios.
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
  //METODO NUEVO
    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        $query = self::with(['usuario'])->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('usuario', function ($q) use ($keyword) {
                    $q->where('nombre', 'like', "%{$keyword}%")
                        ->orWhere('apellido', 'like', "%{$keyword}%")
                        ->orWhere('CI_', 'like', "%{$keyword}%");
                })->orWhere('consulta', 'like', "%{$keyword}%")
                ->orWhere('fechaBusqueda', 'like', "%{$keyword}%")
                ->orWhere('resultado', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }
}
