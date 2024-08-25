<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('historial_viajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTrayecto');
            $table->unsignedBigInteger('idAutobus');
            $table->unsignedBigInteger('idUsuario');
            $table->dateTime('tiempo_inicio');
            $table->dateTime('tiempo_fin')->nullable();
            $table->time('duracion')->nullable();
            $table->string('estado')->default('en progreso');  

            $table->foreign('idTrayecto')->references('id')->on('trayectos')->onDelete('cascade');
            $table->foreign('idAutobus')->references('id')->on('autobuses')->onDelete('cascade');
            $table->foreign('idUsuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('historial_viajes');
    }
};
