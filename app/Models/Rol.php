<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rols';

    protected $fillable = [
        'nombreRol',
    ];
    
    // Relación con usuarios
    public function users()
    {
        return $this->belongsToMany(User::class, 'rol_usuarios', 'rol_id', 'usuario_id');
    }

    public function Usuario()
    {
        return $this->belongsToMany(Usuario::class, 'rol_usuarios', 'rol_id', 'usuario_id')
                                  ->using(RolUsuario::class);
    }
}
