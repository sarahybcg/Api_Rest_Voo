<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('busquedas', function (Blueprint $table) {
            $table->id();  
            $table->string('ciUsuario', 10);  
            $table->string('consulta', 50);   
            $table->date('fechaBusqueda')->nullable();  
            $table->text('resultado')->nullable();  
            $table->foreign('ciUsuario')
                  ->references('CI_')
                  ->on('usuarios')
                  ->onDelete('cascade');  
            $table->timestamps(); 
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('busquedas');
    }
};
