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
        Schema::table('autobuses', function (Blueprint $table) {
            
            Schema::table('autobuses', function (Blueprint $table) {
                $table->string('idUsuario', 10)->change();  // Ajusta el tamaño del varchar según corresponda
            });
          
            Schema::table('autobuses', function (Blueprint $table) {
                $table->dropForeign(['idUsuario']);
            });
            // Crear la relación con la tabla 'usuarios' y la columna 'CI_'
            $table->foreign('idUsuario')->references('CI_')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
        });
    }

  
   
};
