<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre' => 'SUPERADMIN',
    'descripcion' => 'Administrador del sistema',
    'estado' => 1,
    'created_at' => '2026-02-14 02:31:47',
    'updated_at' => '2026-02-14 02:31:47',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'ESTUDIANTE',
    'descripcion' => 'Estudiante de colegio',
    'estado' => 1,
    'created_at' => '2026-02-14 02:31:47',
    'updated_at' => '2026-02-14 02:31:47',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'RECTOR',
    'descripcion' => 'Rector de colegio',
    'estado' => 1,
    'created_at' => '2026-02-14 02:31:47',
    'updated_at' => '2026-02-14 02:31:47',
  ),
  3 => 
  array (
    'id' => 4,
    'nombre' => 'DOCENTE',
    'descripcion' => 'Docente de colegio',
    'estado' => 1,
    'created_at' => '2026-02-14 02:31:47',
    'updated_at' => '2026-02-14 02:31:47',
  ),
  4 => 
  array (
    'id' => 5,
    'nombre' => 'ACUDIENTE',
    'descripcion' => 'Acudiente o padre de familia',
    'estado' => 1,
    'created_at' => '2026-02-28 03:47:59',
    'updated_at' => '2026-02-28 03:47:59',
  ),
);

        foreach ($data as $row) {
            Rol::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
