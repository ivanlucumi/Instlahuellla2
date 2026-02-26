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
        Schema::create('grado_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_grado'); // Renamed from nombre_grado_academico
            $table->string('bloque')->nullable(); // Renamed and made nullable
            $table->unsignedBigInteger('sede_id')->nullable(); // Made nullable
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->boolean('estado_grado_academico')->default(true);
            $table->unsignedBigInteger('docente_id')->nullable(); // Made nullable
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('cascade');
            // curso_id and periodos were added then removed, so they are not included here.
            // asignatura_id was added then removed, so not included.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grado_academicos');
    }
};
