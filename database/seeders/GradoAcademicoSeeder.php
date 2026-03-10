<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GradoAcademico;

class GradoAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre_grado' => 'CERO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => 1,
    'created_at' => NULL,
    'updated_at' => '2026-03-07 13:21:20',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre_grado' => 'PRIMERO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  2 => 
  array (
    'id' => 3,
    'nombre_grado' => 'SEGUNDO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  3 => 
  array (
    'id' => 4,
    'nombre_grado' => 'TERCERO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  4 => 
  array (
    'id' => 5,
    'nombre_grado' => 'CUARTO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  5 => 
  array (
    'id' => 6,
    'nombre_grado' => 'QUINTO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  6 => 
  array (
    'id' => 7,
    'nombre_grado' => 'SEXTO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  7 => 
  array (
    'id' => 8,
    'nombre_grado' => 'SEPTIMO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  8 => 
  array (
    'id' => 9,
    'nombre_grado' => 'OCTAVO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  9 => 
  array (
    'id' => 10,
    'nombre_grado' => 'NOVENO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  10 => 
  array (
    'id' => 11,
    'nombre_grado' => 'DECIMO',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  11 => 
  array (
    'id' => 12,
    'nombre_grado' => 'ONCE',
    'bloque' => 'G',
    'sede_id' => 1,
    'curso_id' => NULL,
    'asignatura_id' => NULL,
    'estado_grado_academico' => 1,
    'docente_id' => NULL,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
);

        foreach ($data as $row) {
            GradoAcademico::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
