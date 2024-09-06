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
        'activo'
    ];
 
    protected $hidden = [
        'clave',
    ];

 
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

    // Relación con la tabla `experiencias`.
    public function experiencias()
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
        return $this->hasOne(Linea::class, 'idUsuario_admin'); 
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuarios', 'usuario_id', 'rol_id')
                                    ->using(RolUsuario::class)
                                    ->withTimestamps();

    }
   
}