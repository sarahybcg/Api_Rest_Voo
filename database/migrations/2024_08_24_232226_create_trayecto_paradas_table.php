<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('trayecto_paradas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trayecto_id'); 
            $table->unsignedBigInteger('parada_id');   

            $table->foreign('trayecto_id')->references('id')->on('trayectos')->onDelete('cascade');  

            $table->foreign('parada_id')->references('id')->on('paradas')->onDelete('cascade');  
            
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('trayecto_paradas');
    }
};
