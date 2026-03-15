<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class OtpMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp_code != $request->otp) {
            return response()->json([
                'message' => 'OTP inválido'
            ], 401);
        }

        if (now()->greaterThan($user->otp_expiration)) {
            return response()->json([
                'message' => 'OTP expirado'
            ], 401);
        }

        return $next($request);
    }
}