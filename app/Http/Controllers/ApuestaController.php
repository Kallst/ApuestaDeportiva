<?php

namespace App\Http\Controllers;

use App\Models\Apuesta;
use App\Models\Evento;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApuestaController extends Controller
{
public function apostar(Request $request): JsonResponse
{
    DB::beginTransaction();

    try {

        $usuario = Auth::user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $evento = Evento::find($request->evento_id);

        if (!$evento) {
            return response()->json([
                'message' => 'El evento no existe'
            ], 404);
        }

        if ($evento->estado !== 'pendiente') {
            return response()->json([
                'message' => 'No se puede apostar en un evento finalizado'
            ], 400);
        }

        $cuota = Cuota::where('evento_id', $request->evento_id)
            ->where('tipo_apuesta', $request->tipo_apuesta)
            ->first();

        if (!$cuota) {
            return response()->json([
                'message' => 'No existe cuota para este evento y tipo de apuesta'
            ], 404);
        }

        if ($usuario->saldo < $request->monto) {
            return response()->json([
                'message' => 'Saldo insuficiente'
            ], 400);
        }

        $apuesta = Apuesta::create([
            'usuario_id' => $usuario->id,
            'evento_id' => $request->evento_id,
            'tipo_apuesta' => $request->tipo_apuesta,
            'monto' => $request->monto,
            'cuota' => $cuota->cuota,
            'estado' => 'pendiente',
            'ganancia' => 0
        ]);

        $usuario->saldo -= $request->monto;
        $usuario->save();

        DB::commit();

        return response()->json([
            'message' => 'Apuesta creada correctamente',
            'data' => $apuesta
        ], 201);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Error al realizar la apuesta',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function misApuestas(): JsonResponse
{
    $usuario = auth()->user();

    if (!$usuario) {
        return response()->json([
            'message' => 'Usuario no autenticado'
        ], 401);
    }

    try {

        $apuestas = Apuesta::with('evento')
            ->where('usuario_id', $usuario->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Estas son tus apuestas',
            'total_apuestas' => $apuestas->count(),
            'data' => $apuestas
        ], 200);

    } catch (\Throwable $e) {

        return response()->json([
            'message' => 'Error al obtener las apuestas',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function cobrar(int $id): JsonResponse
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $apuesta = Apuesta::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        if ($apuesta->estado !== 'ganada') {
            return response()->json([
                'message' => 'La apuesta no es ganadora'
            ], 400);
        }

        if ($apuesta->ganancia <= 0) {
            return response()->json([
                'message' => 'La apuesta ya fue cobrada'
            ], 400);
        }

        DB::beginTransaction();

        try {

            $usuario->saldo += $apuesta->ganancia;
            $usuario->save();

            $apuesta->ganancia = 0;
            $apuesta->save();

            DB::commit();

            return response()->json([
                'message' => 'Ganancia cobrada correctamente',
                'saldo_actual' => $usuario->saldo
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Error al cobrar la apuesta',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}