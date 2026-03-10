<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre_curso' => '1',
    'descripcion' => 'JBJBJ',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:40:04',
    'updated_at' => '2026-02-14 02:40:04',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre_curso' => '2',
    'descripcion' => 'JHJH',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:40:19',
    'updated_at' => '2026-02-14 02:40:19',
  ),
);

        foreach ($data as $row) {
            Curso::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
