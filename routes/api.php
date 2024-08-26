<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\RolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ValoracionController;

Route::apiResource('/usuarios', UsuarioController::class);
Route::apiResource('/rols', RolController::class);
Route::apiResource('/lineas', LineaController::class);
Route::apiResource('/valoracions', ValoracionController::class);
Route::apiResource('/experiencias', ExperienciaController::class);
Route::apiResource('/comentarios', ComentarioController::class);
Route::apiResource('/condicions', CondicionController::class);