<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'saldo' => 0,
            'rol' => 'usuario'
        ]);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = Auth::user();

        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expiration = now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'OTP enviado al correo'
        ]);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->otp_code != $request->otp) {
            return response()->json([
                'message' => 'OTP incorrecto'
            ], 401);
        }

        if (now()->greaterThan($user->otp_expiration)) {
            return response()->json([
                'message' => 'OTP expirado'
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        $user->otp_code = null;
        $user->otp_expiration = null;
        $user->save();

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
