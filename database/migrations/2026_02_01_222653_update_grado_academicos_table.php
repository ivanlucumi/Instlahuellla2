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
        Schema::table('grado_academicos', function (Blueprint $table) {
            $table->renameColumn('nombre_grado_academico', 'nombre_grado');
            $table->renameColumn('bloque_grado_academico', 'bloque');
            $table->unsignedBigInteger('curso_id')->nullable()->after('docente_id');
            $table->unsignedBigInteger('asignatura_id')->nullable()->after('curso_id');
            
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('set null');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grado_academicos', function (Blueprint $table) {
            $table->dropForeign(['asignatura_id']);
            $table->dropForeign(['curso_id']);
            $table->dropColumn(['curso_id', 'asignatura_id']);
            $table->renameColumn('nombre_grado', 'nombre_grado_academico');
            $table->renameColumn('bloque', 'bloque_grado_academico');
        });
    }
};
