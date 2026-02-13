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
        Schema::create('notas_definitivas', function (Blueprint $table) {
            $table->id();
            $table->string('documento_estudiante');
            $table->string('nombre_estudiante');
            $table->string('grado_aprobado');
            $table->decimal('nota_per1', 5, 2);
            $table->decimal('nota_per2', 5, 2);
            $table->decimal('nota_per3', 5, 2);
            $table->decimal('nota_per4', 5, 2);
            $table->decimal('nota_definitiva', 5, 2);
            $table->string('nombre_asignatura');
            $table->string('curso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_definitivas');
    }
};
