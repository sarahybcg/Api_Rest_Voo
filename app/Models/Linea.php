<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;

    public $table= "lineas";
    
    protected $fillable=array("*");  

        
       public function trayecto()
       {
           return $this->belongsToMany(Trayecto::class, 'linea_trayecto');  
       }
}
