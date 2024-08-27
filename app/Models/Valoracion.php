<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    public $table= "valoracions";

    protected $fillable= [
        'estrellas',
    ];

    // una valoracion puede pertenecer a varias exp
    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'idValoracion');
    }
}
