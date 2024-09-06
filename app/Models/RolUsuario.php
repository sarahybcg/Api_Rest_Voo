<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolUsuario extends Pivot
{
    // Especificar la tabla pivote si el nombre no sigue las convenciones
    protected $table = 'rol_usuarios'; // Puedes omitir esto si tu tabla se llama "rol_usuario"

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'usuario_id',
        'rol_id',
    ];

    // Deshabilitar timestamps si no se usan en la tabla pivote
    public $timestamps = false;

    // Si tu tabla pivote tiene timestamps, puedes omitir esta propiedad o dejarla en true.
}
