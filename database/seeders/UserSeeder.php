<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@apuestas.com',
            'password' => Hash::make('123456'),
            'saldo' => 10000,
            'rol' => 'admin'
        ]);

        User::create([
            'nombre' => 'Usuario',
            'email' => 'usuario@apuestas.com',
            'password' => Hash::make('123456'),
            'saldo' => 50000,
            'rol' => 'usuario'
        ]);
    }
}