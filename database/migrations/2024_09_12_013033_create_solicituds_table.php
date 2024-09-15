<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitante_id')  
                ->constrained('usuarios')
                ->onDelete('cascade');
            $table->foreignId('receptor_id')  
                ->constrained('usuarios')
                ->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');  
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
