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
        Schema::table('institucions', function (Blueprint $table) {
            if (!Schema::hasColumn('institucions', 'jerarquia')) $table->string('jerarquia')->default('CALOTO')->nullable();
            if (!Schema::hasColumn('institucions', 'calendario')) $table->string('calendario')->default('A')->nullable();
            if (!Schema::hasColumn('institucions', 'sector')) $table->string('sector')->default('OFICIAL')->nullable();
            if (!Schema::hasColumn('institucions', 'modelo')) $table->string('modelo')->default('ETNOEDUCACIÓN')->nullable();
            if (!Schema::hasColumn('institucions', 'jornada')) $table->string('jornada')->default('MAÑANA')->nullable();
        });

        Schema::table('sedes', function (Blueprint $table) {
            if (!Schema::hasColumn('sedes', 'zona_sede')) $table->string('zona_sede')->default('RURAL')->nullable();
            if (!Schema::hasColumn('sedes', 'jornada')) $table->string('jornada')->default('MAÑANA')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('institucions', function (Blueprint $table) {
            $table->dropColumn(['jerarquia', 'calendario', 'sector', 'modelo', 'jornada']);
        });

        Schema::table('sedes', function (Blueprint $table) {
            $table->dropColumn(['zona_sede', 'jornada']);
        });
    }
};
