<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public $table= "marcas";

    protected $fillable=[
        'nombre',
    ];

 //hasMany para indicar que un marc puede estar asociado con varios modelos.

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'idMarca');
    }

    public static function searchAndPaginate($keyword = null, $perPage = 10)
    {
        $query = self::query()->latest('created_at');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nombre', 'like', "%{$keyword}%");
            });
        }
        return $query->paginate($perPage);
    }
}
