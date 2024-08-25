<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('comentario');
            $table->unsignedBigInteger('idExperiencia');
            $table->foreign('idExperiencia')->references('id')->on('experiencias');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
