<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'CI_',  
        'nombre',
        'clave', // Si usas 'clave' en lugar de 'password'
    ];

    // Relación con roles
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuarios', 'usuario_id', 'rol_id');
    }
}