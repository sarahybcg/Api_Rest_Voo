<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('trayectos', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre_trayecto',80)->nullable();
            $table->text('descripcion');
            $table->string('origen',255);
            $table->string('destino',255);
            $table->decimal('distancia', 10, 2)->nullable();
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('trayectos');
    }
};
