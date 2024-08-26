<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    use HasFactory;

    public $table= "prioridads";

    protected $fillable=[
        'nombrePrioridad',
    ];

 //hasMany para indicar que una prioridad puede estar asociada con varios notif.
        public function notificacion()
        {
            return $this->hasMany(Notificacion::class, 'idPrioridad');
        }
}
