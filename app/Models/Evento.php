<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'deporte',
        'equipo_local',
        'equipo_visitante',
        'fecha',
        'estado'
    ];

    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }

    public function apuestas()
    {
        return $this->hasMany(Apuesta::class);
    }
}