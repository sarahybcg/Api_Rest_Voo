<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('prioridads', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombrePrioridad', 50);
            $table->timestamps(); 
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('prioridads');
    }
};
