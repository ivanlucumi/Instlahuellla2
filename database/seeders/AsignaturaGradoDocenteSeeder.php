<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignaturaGradoDocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('asignatura_grado_docente')->truncate();
        $data = array (
  0 => 
  array (
    'id' => 4,
    'asignatura_id' => 16,
    'grado_academico_id' => 1,
    'docente_id' => 74,
    'created_at' => '2026-03-07 13:22:09',
    'updated_at' => '2026-03-07 13:22:09',
  ),
  1 => 
  array (
    'id' => 5,
    'asignatura_id' => 22,
    'grado_academico_id' => 1,
    'docente_id' => 50,
    'created_at' => '2026-03-07 13:22:09',
    'updated_at' => '2026-03-07 13:22:09',
  ),
  2 => 
  array (
    'id' => 6,
    'asignatura_id' => 100,
    'grado_academico_id' => 1,
    'docente_id' => 40,
    'created_at' => '2026-03-07 13:22:09',
    'updated_at' => '2026-03-07 13:22:09',
  ),
);

        foreach (array_chunk($data, 100) as $chunk) {
            DB::table('asignatura_grado_docente')->insert($chunk);
        }
    }
}
