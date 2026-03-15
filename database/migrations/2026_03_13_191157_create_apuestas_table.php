<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('tipo_apuesta');
            $table->decimal('monto', 10, 2);
            $table->decimal('cuota', 8, 2);
            $table->string('estado')->default('pendiente');
            $table->decimal('ganancia', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apuestas');
    }
};