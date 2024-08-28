<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autobus extends Model
{
    use HasFactory;

    public $table = "autobuses";

    protected $fillable = [
        'Placa_',
        'idLinea',
        'idUsuario',
        'capacidad',
        'idModelo',
        'idCondicion',
    ];


    public function linea()
    {
        return $this->belongsTo(Linea::class, 'idLinea');
    }
 
    public function propietario()
    {
        return $this->belongsTo(propietario::class, 'idUsuario');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'idModelo');
    }

    public function condicion()
    {
        return $this->belongsTo(Condicion::class, 'idCondicion');
    }

    public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idAutobus');
    }

    //METODO NUEVO
    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        // Cargar las relaciones necesarias
        $query = self::with(['linea', 'modelo.marca', 'condicion', 'usuario'])->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('Placa_', 'like', "%{$keyword}%")
                    ->orWhereHas('linea', function ($q) use ($keyword) {
                        $q->where('nombre', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('modelo', function ($q) use ($keyword) {
                        $q->where('nombre', 'like', "%{$keyword}%")
                            ->orWhereHas('marca', function ($q) use ($keyword) {
                                $q->where('nombre', 'like', "%{$keyword}%");
                            });
                    });
            });
        }

        return $query->paginate($perPage);
    }
}
