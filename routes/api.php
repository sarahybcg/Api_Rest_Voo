<?php
use  App\Http\Controllers\StoreController;
use App\Http\Controllers\AutobusController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\HistorialViajeController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ParadaController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TrayectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ValoracionController;
use App\Models\HistorialViaje;
use App\Http\Controllers\AuthController; // Asegúrate de importar el controlador de autenticación


Route::apiResource('/usuarios', UsuarioController::class);
Route::apiResource('/rols', RolController::class);
Route::apiResource('/lineas', LineaController::class);
Route::apiResource('/valoracions', ValoracionController::class);
Route::apiResource('/experiencias', ExperienciaController::class);
Route::apiResource('/comentarios', ComentarioController::class);
Route::apiResource('/condicions', CondicionController::class);
Route::apiResource('/propietarios', PropietarioController::class);
Route::apiResource('/conductors', ConductorController::class);
Route::apiResource('/busquedas', BusquedaController::class);
Route::apiResource('/trayectos', TrayectoController::class);
Route::apiResource('/marcas', MarcaController::class);
Route::apiResource('/modelos', ModeloController::class);
Route::apiResource('/autobuses', AutobusController::class);
Route::apiResource('/historial_viajes', HistorialViajeController::class);
Route::apiResource('/paradas', ParadaController::class);
Route::apiResource('/prioridads', PrioridadController::class);
Route::apiResource('/notificacions', NotificacionController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/store', [StoreController::class, 'store']);
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::put('/usuarios/CI_}', [UsuarioController::class, 'update']);
