<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUsuario');  
            $table->string('titulo', 80);
            $table->string('descripcion', 255);
            $table->dateTime('fechaEnvio');
            $table->unsignedBigInteger('idPrioridad');

            $table->foreign('idUsuario')
              ->references('id')
              ->on('usuarios')
              ->onDelete('cascade');  
              
            $table->foreign('idPrioridad')
              ->references('id')
              ->on('prioridads')
              ->onDelete('cascade'); 
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('notificacions');
    }
};
