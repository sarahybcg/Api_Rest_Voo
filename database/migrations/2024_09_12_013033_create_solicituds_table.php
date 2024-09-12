<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('solicituds', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('idConductor');
        $table->unsignedBigInteger('idPropietario'); // Añadido
        $table->unsignedBigInteger('idRol');
        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
        $table->timestamps();

        $table->foreign('idConductor')->references('id')->on('conductors')->onDelete('cascade');
        $table->foreign('idPropietario')->references('id')->on('usuarios')->onDelete('cascade');  
        $table->foreign('idRol')->references('id')->on('rols')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
