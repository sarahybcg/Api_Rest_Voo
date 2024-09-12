<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivoToUsuariosTable extends Migration
{
    public function up(): void
    {
      /*  Schema::table('usuarios', function (Blueprint $table) {
            $table->boolean('activo')->default(true); // Agrega el nuevo campo 'activo'
        });*/
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('activo'); // Elimina el campo 'activo' si es necesario revertir la migración
        });
    }
};