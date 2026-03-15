<?php

namespace App\Http\Controllers;

use App\Models\Apuesta;
use App\Models\Evento;
use App\Models\Cuota;
use App\Models\User;
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

            $cuota = Cuota::where('evento_id', $request->evento_id)
                ->where('tipo_apuesta', $request->tipo_apuesta)
                ->firstOrFail();

            $ganancia = $request->monto * $cuota->cuota;

            $apuesta = Apuesta::create([
                'usuario_id' => $usuario->id,
                'evento_id' => $request->evento_id,
                'tipo_apuesta' => $request->tipo_apuesta,
                'monto' => $request->monto,
                'cuota' => $cuota->cuota,
                'estado' => 'pendiente',
                'ganancia' => $ganancia
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
        $usuario = Auth::user();

        $apuestas = Apuesta::where('usuario_id', $usuario->id)
            ->with('evento')
            ->get();

        return response()->json($apuestas);
    }

    public function cobrar(int $id): JsonResponse
    {
        $usuario = Auth::user();

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
