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
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_sede');
            $table->string('descripcion_sede');
            $table->string('codigo_dane_sede');
            $table->string('resolucion_sede');
            $table->unsignedBigInteger('institucion_id');
            $table->foreign('institucion_id')->references('id')->on('institucions')->onDelete('cascade');
            $table->boolean('estado_sede')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
