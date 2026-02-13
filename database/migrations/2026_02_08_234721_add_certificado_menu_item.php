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
        // Obtener el ID del rol SUPERADMIN de forma dinámica
        $rol = \DB::table('rol')->where('nombre', 'SUPERADMIN')->first();
        
        // Si no existe SUPERADMIN, intentar con el primer rol disponible como fallback
        if (!$rol) {
            $rol = \DB::table('rol')->first();
        }

        if ($rol) {
            \DB::table('menu')->insert([
                'nombre'         => 'Certificados',
                'nombre_submenu' => 'Generar Notas',
                'icono'          => 'fa fa-file-pdf',
                'url'            => 'admin.certificados.index',
                'tipo'           => 'dropdown',
                'estado'         => true,
                'rol_id'         => $rol->id,
                'orden'          => 10,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('menu')->where('url', 'admin.certificados.index')->delete();
    }
};
