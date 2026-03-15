<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use App\Models\Resultado;
use App\Models\Apuesta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function crearEvento(Request $request): JsonResponse
    {
        $evento = Evento::create([
            'deporte' => $request->deporte,
            'equipo_local' => $request->equipo_local,
            'equipo_visitante' => $request->equipo_visitante,
            'fecha' => $request->fecha,
            'estado' => 'pendiente'
        ]);

        return response()->json([
            'message' => 'evento creado correctamente',
            'data' => $evento
        ], 201);
    }

    public function verApuestas(): JsonResponse
    {
        $apuestas = Apuesta::with(['usuario', 'evento'])->get();

        if ($apuestas == null){
            return response()->json([
                'message'=> 'No hay apuestas en este momento',
                'data'=> null
            ], 404);
        }

        return response()->json([
            'messsage' => 'Estas son las apuestas',
            'data' => $apuestas
        ], 200);
    }

    public function ajustarSaldo(Request $request, int $id): JsonResponse
    {
        if ($request -> monto < 0){
            return response()->json([
                'message'=> 'No puede agregar un monto negativo',
                'data'=> $request -> monto
            ], 422);
        }

        $user = User::findOrFail($id);
        $user -> saldo += $request->monto;
        $user -> save();

        return response()->json([
            'message' => 'Saldo ajustado correctamente',
            'data' => $user->saldo
        ], 201);
    }

    public function simularResultado(Request $request): JsonResponse
{
    DB::beginTransaction();

    try {

        $resultado = Resultado::create([
            'evento_id' => $request->evento_id,
            'resultado' => $request->resultado
        ]);

        $evento = Evento::findOrFail($request->evento_id);
        $evento->estado = 'finalizado';
        $evento->save();

        $apuestas = Apuesta::where('evento_id', $request->evento_id)->get();

        foreach ($apuestas as $apuesta) {

            if ($apuesta->tipo_apuesta === $request->resultado) {

                $ganancia = $apuesta->monto * $apuesta->cuota;

                $apuesta->estado = 'ganada';
                $apuesta->ganancia = $ganancia;
                $apuesta->save();

                $usuario = User::find($apuesta->user_id);

                $usuario->saldo += $ganancia;
                $usuario->save();

            } else {

                $apuesta->estado = 'perdida';
                $apuesta->ganancia = 0;
                $apuesta->save();
            }
        }

        DB::commit();

        return response()->json([
            'message' => 'Resultado simulado correctamente'
        ], 201);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Error al simular resultado',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
