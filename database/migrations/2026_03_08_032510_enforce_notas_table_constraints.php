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
            $table->unsignedBigInteger('matriculado_id')->nullable(false)->change();
            $table->unsignedBigInteger('periodo_academico_id')->nullable(false)->change();
            $table->unsignedBigInteger('estudiante_id')->nullable(false)->change();
            $table->unsignedBigInteger('grado_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->unsignedBigInteger('matriculado_id')->nullable(true)->change();
            $table->unsignedBigInteger('periodo_academico_id')->nullable(true)->change();
            $table->unsignedBigInteger('estudiante_id')->nullable(true)->change();
            $table->unsignedBigInteger('grado_id')->nullable(true)->change();
        });
    }
};
