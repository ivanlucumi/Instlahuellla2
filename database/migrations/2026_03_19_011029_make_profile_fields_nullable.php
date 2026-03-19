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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->string('codigo_estudiante')->nullable()->change();
            $table->date('fecha_nacimiento_estudiante')->nullable()->change();
            $table->string('genero_estudiante')->nullable()->change();
            $table->string('foto_estudiante')->nullable()->change();
            $table->string('anho_curso_estudiante')->nullable()->change();
            $table->string('direccion_estudiante')->nullable()->change();
            $table->string('telefono_estudiante')->nullable()->change();
            $table->string('email_estudiante')->nullable()->change();
            $table->string('tipo_identificacion_estudiante')->nullable()->change();
            $table->string('numero_identificacion_estudiante')->nullable()->change();
            $table->unsignedBigInteger('acudiente_id')->nullable()->change();
            $table->unsignedBigInteger('grado_academico_id')->nullable()->change();
        });

        Schema::table('docentes', function (Blueprint $table) {
            $table->string('codigo_docente')->nullable()->change();
            $table->string('genero_docente')->nullable()->change();
            $table->string('foto_docente')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->string('codigo_estudiante')->nullable(false)->change();
            $table->date('fecha_nacimiento_estudiante')->nullable(false)->change();
            $table->string('genero_estudiante')->nullable(false)->change();
            $table->string('foto_estudiante')->nullable(false)->change();
            $table->string('anho_curso_estudiante')->nullable(false)->change();
            $table->string('direccion_estudiante')->nullable(false)->change();
            $table->string('telefono_estudiante')->nullable(false)->change();
            $table->string('email_estudiante')->nullable(false)->change();
            $table->string('tipo_identificacion_estudiante')->nullable(false)->change();
            $table->string('numero_identificacion_estudiante')->nullable(false)->change();
            $table->unsignedBigInteger('acudiente_id')->nullable(false)->change();
            $table->unsignedBigInteger('grado_academico_id')->nullable(false)->change();
        });

        Schema::table('docentes', function (Blueprint $table) {
            $table->string('codigo_docente')->nullable(false)->change();
            $table->string('genero_docente')->nullable(false)->change();
            $table->string('foto_docente')->nullable(false)->change();
        });
    }
};
