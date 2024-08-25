<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('linea_trayectos', function (Blueprint $table) { 
            $table->id();
            $table->unsignedBigInteger('idLinea');
            $table->unsignedBigInteger('idTrayecto'); 

            $table->foreign('idLinea')->references('id')->on('lineas')->onDelete('cascade');

            $table->foreign('idTrayecto')->references('id')->on('trayectos')->onDelete('cascade');

            $table->timestamps();  
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('linea_trayectos');
    }
};
