<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    use HasFactory;

    public $table= "Condicions";

    protected $fillable =array("*");
 
    public function autobus()
    {
        return $this->hasMany(Autobus::class, 'idCondicion');
    }
}
