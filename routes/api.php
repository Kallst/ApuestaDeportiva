<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ApuestaController;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
