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
            $table->dropForeign(['asignatura_id']);
            $table->dropColumn('asignatura_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grado_academicos', function (Blueprint $table) {
            $table->unsignedBigInteger('asignatura_id')->nullable()->after('curso_id');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('set null');
        });
    }
};
