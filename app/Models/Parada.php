<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parada extends Model
{
    use HasFactory;

    public $table= "paradas";
    
    protected $fillable=array("*");
    
       public function trayecto()
       {
           return $this->belongsToMany(Trayecto::class, 'trayecto_paradas');  
       }
}
