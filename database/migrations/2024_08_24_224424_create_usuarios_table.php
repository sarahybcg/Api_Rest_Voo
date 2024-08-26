<?php
use App\Models\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{  protected $model = Usuario::class;
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();  
            $table->string('CI_', 10)->unique(); 
            $table->string('nombre', 40);
            $table->string('apellido', 40);
            $table->string('telefono_', 20);
            $table->date('fechaNacimiento');
            $table->string('clave', 255);
            $table->unsignedBigInteger('idRol');
            $table->foreign('idRol')->references('id')->on('rols');
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
