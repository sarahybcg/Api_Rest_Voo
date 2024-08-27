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
}
