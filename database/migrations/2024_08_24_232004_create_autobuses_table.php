<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('autobuses', function (Blueprint $table) {
            $table->id();
            $table->string('Placa_', 15)->unique();
            $table->unsignedBigInteger('idLinea');
            $table->unsignedBigInteger('idUsuario');
            $table->integer('capacidad');
            $table->unsignedBigInteger('idModelo');
            $table->unsignedBigInteger('idCondicion');

            $table->foreign('idLinea')->references('id')->on('lineas')->onDelete('cascade');
            $table->foreign('idUsuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('idModelo')->references('id')->on('modelos')->onDelete('cascade');
            $table->foreign('idCondicion')->references('id')->on('condicions')->onDelete('cascade');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('autobuses');
    }
};
