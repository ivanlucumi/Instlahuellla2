<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AnhoEscolar;

class AnhoEscolarSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre_anho_escolar' => '2026',
    'fecha_inicio_anho_escolar' => '2026-02-02',
    'fecha_fin_anho_escolar' => '2026-12-11',
    'estado_anho_escolar' => 1,
    'descripcion_anho_escolar' => 'MNBM',
    'created_at' => '2026-02-14 02:36:46',
    'updated_at' => '2026-02-14 02:36:46',
  ),
);

        foreach ($data as $row) {
            AnhoEscolar::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
