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
        Schema::table('asignaturas', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['sede_id']);
            $table->dropForeign(['docente_id']);
            
            // Drop columns
            $table->dropColumn(['sede_id', 'descripcion', 'creditos', 'docente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignaturas', function (Blueprint $table) {
            $table->unsignedBigInteger('sede_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('creditos')->nullable();
            $table->unsignedBigInteger('docente_id')->nullable();

            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
