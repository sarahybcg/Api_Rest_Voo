<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    
    protected $table = 'solicituds';

    protected $fillable = [
        'idConductor',
        'idRol',
        'estado',
    ];
 
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'idConductor');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }
}
