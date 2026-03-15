<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\OtpMiddleware;
use App\Http\Middleware\CheckSaldoMiddleware;
use App\Http\Middleware\CheckEventoAbiertoMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'otp' => OtpMiddleware::class,
            'saldo' => CheckSaldoMiddleware::class,
            'evento.abierto' => CheckEventoAbiertoMiddleware::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();