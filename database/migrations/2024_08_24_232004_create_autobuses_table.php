<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('autobuses', function (Blueprint $table) {
            $table->string('Placa_', 15)->primary();
            $table->string('nombreLinea', 15);
            $table->string('ciUsuario', 10);
            $table->integer('capacidad');
            $table->unsignedBigInteger('idModelo');
            $table->unsignedBigInteger('idCondicion');
            $table->foreign('nombreLinea')->references('Linea_')->on('lineas');
            $table->foreign('ciUsuario')->references('CI_')->on('usuarios');
            $table->foreign('idModelo')->references('id')->on('modelos');
            $table->foreign('idCondicion')->references('id')->on('condicions');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('autobuses');
    }
};
