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
            $table->year('autobusesanio')->after('idCondicion')->nullable(); // Asegúrate de cambiar 'column_name' por la columna después de la cual quieras agregar el año
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('autobuses', function (Blueprint $table) {
            $table->dropColumn('autobusesanio');
        });
    }
};

