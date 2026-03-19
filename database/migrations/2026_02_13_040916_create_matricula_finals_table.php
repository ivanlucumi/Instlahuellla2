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
        Schema::create('matricula_finals', function (Blueprint $table) {
            $table->id();
            $table->string('documento_estudiante');
            $table->unsignedBigInteger('id_sede');
            $table->unsignedBigInteger('id_grado');
            $table->string('curso');
            $table->string('ano_lectivo');
            $table->date('fecha');
            $table->string('estado');
            $table->unsignedBigInteger('id_profesor');
            $table->string('documento_acudiente');
            $table->string('parentezco_acudiente');
            
            $table->foreign('id_sede')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('id_grado')->references('id')->on('grado_academicos')->onDelete('cascade');
            $table->foreign('id_profesor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('documento_estudiante')->references('numero_identificacion_estudiante')->on('estudiantes')->onDelete('cascade');
            $table->foreign('documento_acudiente')->references('id_documento')->on('acudientes')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula_finals');
    }
};
