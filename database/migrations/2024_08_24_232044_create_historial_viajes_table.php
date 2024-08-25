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
            $table->unsignedBigInteger('trayecto_id');
            $table->string('placa_autobus', 15);
            $table->string('ci_usuario', 10);
            $table->dateTime('tiempo_inicio');
            $table->dateTime('tiempo_fin')->nullable();
            $table->time('duracion')->nullable();
            $table->string('estado')->default('en progreso');  

            $table->foreign('trayecto_id')->references('id')->on('trayectos');
            $table->foreign('placa_autobus')->references('Placa_')->on('autobuses');
            $table->foreign('ci_usuario')->references('CI_')->on('usuarios');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('historial_viajes');
    }
};
