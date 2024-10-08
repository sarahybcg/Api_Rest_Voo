<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lineas', function (Blueprint $table) {
            $table->id();
            $table->string('Linea_', 15)->unique();
            $table->string('Rif_', 15)->unique();
            $table->unsignedBigInteger('idUsuario_admin');
            $table->text('Dir_Oficina', 15);
            $table->foreign('idUsuario_admin')->references('id')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('lineas');
    }
};
