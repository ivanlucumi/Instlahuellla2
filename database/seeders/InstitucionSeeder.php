<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institucion;

class InstitucionSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 4,
    'nombre_institucion' => 'C.E.R.M. LA HUELLA - SEDE PRINCIPAL
',
    'descripcion_institucion' => 'C.E.R.M. LA HUELLA - SEDE PRINCIPAL
',
    'codigo_dane' => '219142000506',
    'ciudad_institucion' => 'CALOTO',
    'departamento_institucion' => 'CAUCA',
    'resolucion_institucion' => '21914200050601',
    'rector_id' => 200,
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
);

        foreach ($data as $row) {
            App\Models\Institucion::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
