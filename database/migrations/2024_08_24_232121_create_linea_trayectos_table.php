<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('linea_trayectos', function (Blueprint $table) { 
            $table->string('nombreLinea', 15);
            $table->unsignedBigInteger('idTrayecto');
            $table->primary(['nombreLinea', 'idTrayecto']);
            $table->foreign('nombreLinea')->references('Linea_')->on('lineas');
            $table->foreign('idTrayecto')->references('id')->on('trayectos');
            $table->timestamps();  
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('linea_trayectos');
    }
};
