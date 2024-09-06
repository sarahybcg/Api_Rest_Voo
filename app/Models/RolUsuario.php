<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
    protected $table = 'rol_usuarios';

    protected $fillable = [
        'usuario_id',
        'rol_id',
    ];

    public $timestamps = false; 
}
