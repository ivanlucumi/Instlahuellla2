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
        $superAdminRole = DB::table('rol')->where('nombre', 'SUPERADMIN')->first();

        if ($superAdminRole) {
            DB::table('menu')->insert([
                'nombre' => 'Auditoría',
                'nombre_submenu' => null,
                'icono' => 'fa fa-history',
                'url' => 'admin.audit.index',
                'tipo' => 'sencillo',
                'estado' => true,
                'rol_id' => $superAdminRole->id,
                'orden' => '99',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('menu')->where('url', 'admin.audit.index')->delete();
    }
};
