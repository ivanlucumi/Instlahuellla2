<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observaciones_grado_cero', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('grado_academico_id')->constrained('grado_academicos')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodo_academicos')->onDelete('cascade');
            $table->foreignId('anho_escolar_id')->constrained('anho_escolar')->onDelete('cascade');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observaciones_grado_cero');
    }
};
