<?php

namespace App\Http\Middleware;

use App\Models\Evento;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventoAbiertoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $evento = Evento::find($request->evento_id);

        if (!$evento || $evento->estado !== 'pendiente') {
            return response()->json([
                'message' => 'El evento no está disponible para apostar'
            ], 400);
        }

        return $next($request);
    }
}