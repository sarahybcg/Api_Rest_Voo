<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->unsignedBigInteger('idMarca');
            $table->foreign('idMarca')->references('id')->on('marcas');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('modelos');
    }
};
