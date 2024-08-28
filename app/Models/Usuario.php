<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $table = "usuarios";
    
    protected $fillable = [
        'id',
        'CI_', 
        'nombre',
        'apellido',
        'telefono_',
        'fechaNacimiento',
        'clave',
    ];
 
    protected $hidden = [
        'clave',
    ];

    /**
     * Relación muchos a muchos con la tabla `rols` a través de la tabla pivote `rol_usuario`.
     */
  
    // Relación con la tabla `busquedas`.
    public function busquedas()
    {
        return $this->hasMany(Busqueda::class, 'idUsuario');
    }

    // Relación con la tabla `notificacions`.
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'idUsuario');
    }
<<<<<<< HEAD
    public function experiencia()
=======

    // Relación con la tabla `experiencias`.
    public function experiencias()
>>>>>>> e01c0281269764e2d11b17e949b811dfd83f37bb
    {
        return $this->hasMany(Experiencia::class, 'idUsuario');
    }

    // Relación uno a uno con la tabla `propietarios`.
    public function propietario()
    {
        return $this->hasOne(Propietario::class, 'idUsuario');
    }

    // Relación uno a uno con la tabla `conductors`.
    public function conductor()
    {
        return $this->hasOne(Conductor::class, 'idUsuario');
    }

    // Relación uno a uno con la tabla `lineas`.
    public function linea()
    {
        return $this->hasOne(Linea::class, 'idUsuario'); 
    }

    // Relación con la tabla `historial_viajes`.
    public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idUsuario');
    }
<<<<<<< HEAD
   //METODO NUEVO
    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        $query = self::query()->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nombre', 'like', "%{$keyword}%")
                  ->orWhere('apellido', 'like', "%{$keyword}%")
                  ->orWhere('CI_', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }
}
    


  
=======
}
>>>>>>> e01c0281269764e2d11b17e949b811dfd83f37bb
