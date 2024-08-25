<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $table= "usuarios";

    protected $fillable=array("*");
 
    //belongsTo para indicar que cada usuario tiene un rol.
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');  
    }

     //belongsTo para indicar que la busqueda pertenece a un usuario.
     public function busqueda()
     {
         return $this->belongsTo(Busqueda::class, 'idBusqueda');  
     }

      //belongsTo para indicar que la notificaciones pertenece a un usuario.
      public function notificacion()
      {
          return $this->belongsTo(Notificacion::class, 'idNotificacion');  
      }

      public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idUsuario');
    }
}
  