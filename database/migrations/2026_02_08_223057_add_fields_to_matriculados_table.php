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
        Schema::table('matriculados', function (Blueprint $table) {
            // Agregar nuevos campos
            $table->unsignedBigInteger('asignatura_id')->after('estudiante_id');
            $table->unsignedBigInteger('acudiente_id')->after('asignatura_id');
            $table->unsignedBigInteger('anho_escolar_id')->after('grado_id');
            $table->enum('estado', ['activo', 'inactivo', 'retirado'])->default('activo')->after('anho_escolar_id');
            $table->date('fecha_matricula')->after('estado');
            $table->text('observaciones')->nullable()->after('fecha_matricula');
            
            // Agregar foreign keys
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->foreign('acudiente_id')->references('id')->on('acudientes')->onDelete('cascade');
            $table->foreign('anho_escolar_id')->references('id')->on('anho_escolar')->onDelete('cascade');
            
            // Índice único compuesto para evitar matrículas duplicadas
            $table->unique(['estudiante_id', 'asignatura_id', 'anho_escolar_id'], 'unique_matricula');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculados', function (Blueprint $table) {
            // Eliminar índice único
            $table->dropUnique('unique_matricula');
            
            // Eliminar foreign keys
            $table->dropForeign(['asignatura_id']);
            $table->dropForeign(['acudiente_id']);
            $table->dropForeign(['anho_escolar_id']);
            
            // Eliminar columnas
            $table->dropColumn([
                'asignatura_id',
                'acudiente_id',
                'anho_escolar_id',
                'estado',
                'fecha_matricula',
                'observaciones'
            ]);
        });
    }
};
