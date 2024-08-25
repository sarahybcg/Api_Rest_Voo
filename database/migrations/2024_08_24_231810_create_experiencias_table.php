<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id(); 
            $table->string('ciUsuario', 10);
            $table->unsignedBigInteger('idValoracion');
            $table->dateTime('fechaEnvio');
            $table->foreign('ciUsuario')->references('CI_')->on('usuarios');
            $table->foreign('idValoracion')->references('id')->on('valoracions');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('experiencias');
    }
};
