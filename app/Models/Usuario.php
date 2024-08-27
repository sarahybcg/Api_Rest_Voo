<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $table= "usuarios";
    protected $fillable=[
        'id',
        'CI_', 
        'nombre',
        'apellido',
        'telefono_',
        'fechaNacimiento',
        'clave',
        'idRol'
    ];
 
    protected $hidden = [
        'clave',
    ];
    //belongsTo para indicar que cada usuario tiene un rol.
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');  
    }

     //belongsTo para indicar que la busqueda pertenece a un usuario.
     public function busqueda()
     {
         return $this->hasMany(Busqueda::class, 'idUsuario');
     }

      //belongsTo para indicar que la notificaciones pertenece a un usuario.
      public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'idUsuario');
    }

    public function experiencia()
    {
        return $this->hasMany(Experiencia::class, 'idUsuario');
    }
    public function propietario()
    {
        return $this->hasOne(Propietario::class, 'idUsuario');
    }

    public function conductor()
    {
        return $this->hasOne(Conductor::class, 'idUsuario');
    }
    public function linea()
    {
        return $this->hasOne(Linea::class, 'idUsuario'); 
    }
    public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idUsuario');
    }

}
  