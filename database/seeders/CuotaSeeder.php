<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuota;

class CuotaSeeder extends Seeder
{
    public function run(): void
    {
        Cuota::create([
            'evento_id' => 1,
            'tipo_apuesta' => 'local',
            'cuota' => 1.8
        ]);

        Cuota::create([
            'evento_id' => 1,
            'tipo_apuesta' => 'empate',
            'cuota' => 3.2
        ]);

        Cuota::create([
            'evento_id' => 1,
            'tipo_apuesta' => 'visitante',
            'cuota' => 2.5
        ]);
    }
}