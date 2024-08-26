 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('idUsuario'); 
            $table->unsignedBigInteger('idValoracion');
            $table->dateTime('fechaEnvio');

            $table->foreign('idUsuario')->references('id')->on('usuarios')->onDelete('cascade');
            
            $table->foreign('idValoracion')->references('id')->on('valoracions');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('experiencias');
    }
};
