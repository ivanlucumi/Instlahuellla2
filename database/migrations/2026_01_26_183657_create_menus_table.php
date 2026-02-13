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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            // Submenú (visible dentro del dropdown)
            $table->string('nombre_submenu')->nullable();

            $table->string('icono')->nullable();
            $table->string('url')->nullable();

            // Define si es menú normal o dropdown
            $table->enum('tipo', ['sencillo', 'dropdown'])->default('sencillo');
            
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('rol_id');
            $table->string('orden');
            $table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
