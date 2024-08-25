<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    use HasFactory;

    public $table= "autobuses";

    protected $fillable =array("*");
 
    public function autobuses()
    {
        return $this->hasMany(Autobus::class, 'idCondicion');
    }
}
