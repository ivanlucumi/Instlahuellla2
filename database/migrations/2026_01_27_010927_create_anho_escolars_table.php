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
        Schema::create('anho_escolar', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_anho_escolar');
            $table->date('fecha_inicio_anho_escolar');
            $table->date('fecha_fin_anho_escolar');
            $table->boolean('estado_anho_escolar')->default(true);
            $table->text('descripcion_anho_escolar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anho_escolar');
    }
};
