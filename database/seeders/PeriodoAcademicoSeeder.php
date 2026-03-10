<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PeriodoAcademico;

class PeriodoAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'año_escolar_id' => 1,
    'nombre_periodo' => 'I',
    'fecha_inicio' => '2026-02-02',
    'fecha_fin' => '2026-04-30',
    'porcentaje_periodo' => '33',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:37:25',
    'updated_at' => '2026-02-14 02:37:25',
  ),
  1 => 
  array (
    'id' => 2,
    'año_escolar_id' => 1,
    'nombre_periodo' => 'II',
    'fecha_inicio' => '2026-04-01',
    'fecha_fin' => '2026-07-31',
    'porcentaje_periodo' => '33',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:38:05',
    'updated_at' => '2026-02-14 02:38:05',
  ),
  2 => 
  array (
    'id' => 3,
    'año_escolar_id' => 1,
    'nombre_periodo' => 'III',
    'fecha_inicio' => '2026-08-03',
    'fecha_fin' => '2026-12-11',
    'porcentaje_periodo' => '33',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:38:43',
    'updated_at' => '2026-02-14 02:38:43',
  ),
);

        foreach ($data as $row) {
            PeriodoAcademico::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
