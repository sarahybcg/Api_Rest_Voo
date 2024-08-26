<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('condicions', function (Blueprint $table) {
            $table->id();
            $table->string('condicion', 50);
            $table->timestamps(); 
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('condicions');
    }
};
