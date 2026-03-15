<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ApuestaController;
use App\Http\Controllers\AdminController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);


Route::middleware(['auth:api'])->group(function () {

    Route::get('/perfil', [UserController::class, 'perfil']);
    Route::get('/saldo', [UserController::class, 'saldo']);

    Route::get('/eventos', [EventoController::class, 'index']);

    Route::post('/apostar', [ApuestaController::class, 'apostar'])
        ->middleware(['saldo', 'evento.abierto']);

    Route::get('/mis-apuestas', [ApuestaController::class, 'misApuestas']);

    Route::post('/cobrar/{id}', [ApuestaController::class, 'cobrar']);

});


Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {

    Route::post('/eventos', [AdminController::class, 'crearEvento']);

    Route::get('/apuestas', [AdminController::class, 'verApuestas']);

    Route::post('/resultados', [AdminController::class, 'simularResultado']);

    Route::post('/usuarios/{id}/saldo', [AdminController::class, 'ajustarSaldo']);

});