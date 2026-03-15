<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        Evento::create([
            'deporte' => 'Fútbol',
            'equipo_local' => 'Real Madrid',
            'equipo_visitante' => 'Barcelona',
            'fecha' => '2026-06-10',
            'estado' => 'pendiente'
        ]);

        Evento::create([
            'deporte' => 'Fútbol',
            'equipo_local' => 'Manchester City',
            'equipo_visitante' => 'Liverpool',
            'fecha' => '2026-06-11',
            'estado' => 'pendiente'
        ]);
    }
}