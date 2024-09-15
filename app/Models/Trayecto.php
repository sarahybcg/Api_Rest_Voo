<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayecto extends Model
{
    use HasFactory;

    public $table= "trayectos";
    
    protected $fillable=[
        'nombre_trayecto',
        'descripcion',
        'origen',
        'destino',
        'distancia',
        'coordenadas',  
    ];

    protected $casts = [
        'coordenadas' => 'array', // convierte el campo tipo JSON en un array
    ];

    public function lineas()
    {
        return $this->belongsToMany(Linea::class, 'linea_trayectos', 'idTrayecto', 'idLinea');
    }
 
    public function paradas()
    {
        return $this->belongsToMany(Parada::class, 'trayecto_paradas', 'trayecto_id', 'parada_id');
    }

       public function historialViajes()
    {
        return $this->hasMany(HistorialViaje::class, 'idTrayecto');
    }
  //METODO NUEVO
    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        $query = self::query()->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nombre_trayecto', 'like', "%{$keyword}%")
                ->orWhere('descripcion', 'like', "%{$keyword}%")
                ->orWhere('origen', 'like', "%{$keyword}%")
                  ->orWhere('destino', 'like', "%{$keyword}%")
                  ->orWhere('distancia', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }
}
