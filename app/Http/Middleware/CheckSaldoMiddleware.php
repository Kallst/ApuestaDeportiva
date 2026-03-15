<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSaldoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->saldo < $request->monto) {
            return response()->json([
                'message' => 'Saldo insuficiente para realizar la apuesta'
            ], 400);
        }

        return $next($request);
    }
}