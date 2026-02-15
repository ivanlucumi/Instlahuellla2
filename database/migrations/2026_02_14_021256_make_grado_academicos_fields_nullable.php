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
            $table->string('bloque')->nullable()->change();
            $table->unsignedBigInteger('sede_id')->nullable()->change();
            $table->unsignedBigInteger('docente_id')->nullable()->change();
            $table->unsignedBigInteger('curso_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grado_academicos', function (Blueprint $table) {
            $table->string('bloque')->nullable(false)->change();
            $table->unsignedBigInteger('sede_id')->nullable(false)->change();
            $table->unsignedBigInteger('docente_id')->nullable(false)->change();
            $table->unsignedBigInteger('curso_id')->nullable(false)->change();
        });
    }
};
