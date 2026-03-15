<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;
use App\Models\User;

class Apuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'evento_id',
        'tipo_apuesta',
        'monto',
        'cuota',
        'estado',
        'ganancia'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}