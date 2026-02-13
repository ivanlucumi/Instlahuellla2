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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_academico_id');
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->decimal('nota', 5, 2);
            $table->string('observaciones');
            $table->unsignedBigInteger('asignatura_id');
            $table->foreign('periodo_academico_id')->references('id')->on('periodo_academicos')->onDelete('cascade');
            $table->foreign('grado_id')->references('id')->on('grado_academicos')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
