<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'nombre_sede' => 'C.E.R.M LA HUELLA',
    'descripcion_sede' => 'C.E.R.M LA HUELLA  Vereda Huellas  codigo dane centro: 219142000506',
    'codigo_dane_sede' => '21914200050601',
    'resolucion_sede' => '219142000506',
    'institucion_id' => 4,
    'estado_sede' => 1,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  1 => 
  array (
    'id' => 2,
    'nombre_sede' => '',
    'descripcion_sede' => '',
    'codigo_dane_sede' => '',
    'resolucion_sede' => '',
    'institucion_id' => 4,
    'estado_sede' => 1,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  2 => 
  array (
    'id' => 4,
    'nombre_sede' => 'ESCUELA RURAL BODEGA ALTA',
    'descripcion_sede' => 'CODIGO DANE CENTRO: 219142000921',
    'codigo_dane_sede' => '21914200050602',
    'resolucion_sede' => '219142000921',
    'institucion_id' => 4,
    'estado_sede' => 1,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
);

        foreach ($data as $row) {
            App\Models\Sede::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
