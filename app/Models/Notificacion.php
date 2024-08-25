<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    public $table= "notificacions";

    protected $fillable=array("*");
    
 //hasMany para indicar que una notif puede estar asociada con varios usuarios.
    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'idNotificacion');  
    }

    //belongsTo para indicar que la notificaciones pertenece a una prioridad.
    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'idPrioridad');  
    }
}
