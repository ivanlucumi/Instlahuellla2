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
        Schema::table('notas', function (Blueprint $table) {
            // Nuevos campos
            $table->unsignedBigInteger('matriculado_id')->nullable()->after('id');
            $table->decimal('nota1', 5, 2)->nullable()->after('asignatura_id');
            $table->decimal('nota2', 5, 2)->nullable()->after('nota1');
            $table->decimal('nota3', 5, 2)->nullable()->after('nota2');
            $table->decimal('nota4', 5, 2)->nullable()->after('nota3');
            $table->decimal('nota_definitiva', 5, 2)->nullable()->after('nota4');

            // Hacer campos antiguos opcionales para evitar errores inmediatos si hay datos
            $table->unsignedBigInteger('periodo_academico_id')->nullable()->change();
            $table->unsignedBigInteger('estudiante_id')->nullable()->change();
            $table->unsignedBigInteger('grado_id')->nullable()->change();
            $table->decimal('nota', 5, 2)->nullable()->change();

            // Relación
            $table->foreign('matriculado_id')->references('id')->on('matriculados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropForeign(['matriculado_id']);
            $table->dropColumn(['matriculado_id', 'nota1', 'nota2', 'nota3', 'nota4', 'nota_definitiva']);
            
            $table->unsignedBigInteger('periodo_academico_id')->nullable(false)->change();
            $table->unsignedBigInteger('estudiante_id')->nullable(false)->change();
            $table->unsignedBigInteger('grado_id')->nullable(false)->change();
            $table->decimal('nota', 5, 2)->nullable(false)->change();
        });
    }
};
