<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    public function index(): JsonResponse
    {
        $eventos = Evento::with('cuotas')
            ->where('estado', 'pendiente')
            ->get();

        return response()->json($eventos);
    }

    public function show(int $id): JsonResponse
    {
        $evento = Evento::with('cuotas')->findOrFail($id);

        return response()->json($evento);
    }
}
