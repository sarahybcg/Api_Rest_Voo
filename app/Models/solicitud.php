<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    use HasFactory;
    
    protected $table = 'solicituds';
 
    protected $fillable = [
        'solicitante_id',
        'receptor_id',
        'estado',
    ]; 
    
    const ESTADOS = [
        'PENDIENTE' => 'pendiente',
        'ACEPTADA' => 'aceptada',
        'RECHAZADA' => 'rechazada',
    ];
 
    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'solicitante_id');
    }
 
    public function receptor()
    {
        return $this->belongsTo(Usuario::class, 'receptor_id');
    }
}
