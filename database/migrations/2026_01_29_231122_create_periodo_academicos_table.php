<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periodo_academicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('año_escolar_id');
            $table->string('nombre_periodo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('porcentaje_periodo');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->foreign('año_escolar_id')->references('id')->on('anho_escolar')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodo_academicos');
    }
};
