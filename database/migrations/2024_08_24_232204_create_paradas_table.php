<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('paradas', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 200);  
            $table->text('descripcion')->nullable();  
            $table->decimal('latitud', 9, 6);  
            $table->decimal('longitud', 9, 6);  
            $table->timestamps(); 
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('paradas');
    }
};
