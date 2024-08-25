<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('valoracions', function (Blueprint $table) {
            $table->id(); 
            $table->integer('estrellas')->check('estrellas >= 1 AND estrellas <= 5'); 
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('valoracions');
    }
};
