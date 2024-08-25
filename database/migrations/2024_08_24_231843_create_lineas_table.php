<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('lineas', function (Blueprint $table) {
            $table->string('Linea_', 15)->primary();
            $table->string('ciUsuario', 10);
            $table->foreign('ciUsuario')->references('CI_')->on('usuarios');  
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('lineas');
    }
};
