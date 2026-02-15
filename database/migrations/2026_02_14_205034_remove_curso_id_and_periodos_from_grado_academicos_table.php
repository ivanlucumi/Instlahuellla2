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
            $table->dropForeign(['curso_id']); // Drop foreign key first if exists
            $table->dropColumn(['curso_id', 'periodos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grado_academicos', function (Blueprint $table) {
            $table->unsignedBigInteger('curso_id')->nullable();
            $table->integer('periodos')->default(4);
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }
};
