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
        Schema::create('institucions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_institucion');
            $table->string('descripcion_institucion');
            $table->string('codigo_dane');
            $table->string('ciudad_institucion');
            $table->string('departamento_institucion');
            $table->string('resolucion_institucion');
            $table->unsignedBigInteger('rector_id');
            $table->foreign('rector_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucions');
    }
};
