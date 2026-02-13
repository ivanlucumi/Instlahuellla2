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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('codigo_estudiante');
            $table->date('fecha_nacimiento_estudiante');    
            $table->string('genero_estudiante');
            $table->string('foto_estudiante');
            $table->string('anho_curso_estudiante');
            $table->string('direccion_estudiante');
            $table->string('telefono_estudiante');
            $table->string('email_estudiante');
            $table->string('tipo_identificacion_estudiante');
            $table->string('numero_identificacion_estudiante');
            $table->boolean('estado_estudiante')->default(true);            
            $table->unsignedBigInteger('acudiente_id');
            $table->foreign('acudiente_id')->references('id')->on('acudientes')->onDelete('cascade');
            $table->unsignedBigInteger('grado_academico_id');
            $table->foreign('grado_academico_id')->references('id')->on('grado_academicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
