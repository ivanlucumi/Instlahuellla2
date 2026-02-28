<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hilo;

class HiloSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre_hilo' => 'UMA KIWE (MADRE TIERRA)',
    'abreviatura' => 'UMA KIWE',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre_hilo' => 'COMUNICACIÓN COMUNITARIA',
    'abreviatura' => 'YUWEKIPNAKA',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre_hilo' => 'PENSAMIENTO MATEMÁTICO',
    'abreviatura' => 'A´PTEPA´KA',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  3 => 
  array (
    'id' => 4,
    'nombre_hilo' => 'GOBIERNO PROPIO',
    'abreviatura' => 'KHABU WEJXIA',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  4 => 
  array (
    'id' => 5,
    'nombre_hilo' => 'ARMONÍA Y EQUILIBRIO',
    'abreviatura' => 'CXACXAHAPHI',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  5 => 
  array (
    'id' => 6,
    'nombre_hilo' => 'ARMONÍA Y EQUILIBRIO',
    'abreviatura' => 'CXACXAHAPHI',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  6 => 
  array (
    'id' => 7,
    'nombre_hilo' => 'FORMACIÓN DE VALORES Y DESARROLLO HUMANO',
    'abreviatura' => 'SKHAY YUWE',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  7 => 
  array (
    'id' => 8,
    'nombre_hilo' => 'TECNOLOGÍA E INFORMÁTICA',
    'abreviatura' => 'SKHAY YUWE',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  8 => 
  array (
    'id' => 9,
    'nombre_hilo' => 'FORMACIÓN DE VALORES Y DESARROLLO HUMANO',
    'abreviatura' => 'KHABU WEJXIA',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
  9 => 
  array (
    'id' => 10,
    'nombre_hilo' => 'ARTÍSTICO Y CULTURAL',
    'abreviatura' => 'Artístico y Cultural',
    'estado' => 'activo',
    'created_at' => '2026-02-14 02:31:48',
    'updated_at' => '2026-02-14 02:31:48',
  ),
);

        foreach ($data as $row) {
            App\Models\Hilo::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
