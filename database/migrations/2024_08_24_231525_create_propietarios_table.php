<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('propietarios', function (Blueprint $table) {
            $table->string('ciUsuario', 10)->primary();
            $table->string('carnetCirculacion', 255);
            $table->foreign('ciUsuario')
                  ->references('CI_')
                  ->on('usuarios')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
