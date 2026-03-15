<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function perfil(): JsonResponse
    {
        $user = Auth::user();

        return response()->json($user);
    }

    public function saldo(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'saldo' => $user->saldo
        ]);
    }
}