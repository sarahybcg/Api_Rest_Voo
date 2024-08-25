<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('conductors', function (Blueprint $table) {
            $table->string('ciUsuario', 10)->primary();
            $table->string('licenciaConducir',255);
            $table->foreign('ciUsuario')->references('CI_')->on('usuarios');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('conductors');
    }
};
