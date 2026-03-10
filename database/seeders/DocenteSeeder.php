<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
  0 => 
  array (
    'id' => 1,
    'user_id' => 201,
    'codigo_docente' => '98080808080',
    'genero_docente' => 'Masculino',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => '2026-02-14 02:36:08',
    'updated_at' => '2026-02-14 02:36:08',
  ),
  1 => 
  array (
    'id' => 2,
    'user_id' => 39,
    'codigo_docente' => '1',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  2 => 
  array (
    'id' => 3,
    'user_id' => 40,
    'codigo_docente' => '76140961',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  3 => 
  array (
    'id' => 4,
    'user_id' => 41,
    'codigo_docente' => '34609355',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  4 => 
  array (
    'id' => 5,
    'user_id' => 44,
    'codigo_docente' => '76145',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  5 => 
  array (
    'id' => 6,
    'user_id' => 45,
    'codigo_docente' => '1067460626',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  6 => 
  array (
    'id' => 7,
    'user_id' => 46,
    'codigo_docente' => '76142426',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  7 => 
  array (
    'id' => 8,
    'user_id' => 47,
    'codigo_docente' => '4652996',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  8 => 
  array (
    'id' => 9,
    'user_id' => 48,
    'codigo_docente' => '25311291',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  9 => 
  array (
    'id' => 10,
    'user_id' => 49,
    'codigo_docente' => '34771479',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  10 => 
  array (
    'id' => 11,
    'user_id' => 50,
    'codigo_docente' => '34771388',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  11 => 
  array (
    'id' => 12,
    'user_id' => 51,
    'codigo_docente' => '10497022',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  12 => 
  array (
    'id' => 13,
    'user_id' => 52,
    'codigo_docente' => '1062290579',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  13 => 
  array (
    'id' => 14,
    'user_id' => 53,
    'codigo_docente' => '98391144',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  14 => 
  array (
    'id' => 15,
    'user_id' => 54,
    'codigo_docente' => '4653139',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  15 => 
  array (
    'id' => 16,
    'user_id' => 55,
    'codigo_docente' => '4652509',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  16 => 
  array (
    'id' => 17,
    'user_id' => 56,
    'codigo_docente' => '34770897',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  17 => 
  array (
    'id' => 18,
    'user_id' => 57,
    'codigo_docente' => '25732434',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  18 => 
  array (
    'id' => 19,
    'user_id' => 58,
    'codigo_docente' => '76140676',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  19 => 
  array (
    'id' => 20,
    'user_id' => 59,
    'codigo_docente' => '1061689514',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  20 => 
  array (
    'id' => 21,
    'user_id' => 60,
    'codigo_docente' => '76142595',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  21 => 
  array (
    'id' => 22,
    'user_id' => 65,
    'codigo_docente' => '4652191',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  22 => 
  array (
    'id' => 23,
    'user_id' => 66,
    'codigo_docente' => '1064433595',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  23 => 
  array (
    'id' => 24,
    'user_id' => 67,
    'codigo_docente' => '1061433673',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  24 => 
  array (
    'id' => 25,
    'user_id' => 68,
    'codigo_docente' => '1061431526',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  25 => 
  array (
    'id' => 26,
    'user_id' => 69,
    'codigo_docente' => '1061438216',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  26 => 
  array (
    'id' => 27,
    'user_id' => 70,
    'codigo_docente' => '2121',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  27 => 
  array (
    'id' => 28,
    'user_id' => 71,
    'codigo_docente' => '1062312039',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  28 => 
  array (
    'id' => 29,
    'user_id' => 72,
    'codigo_docente' => '1061435757',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  29 => 
  array (
    'id' => 30,
    'user_id' => 73,
    'codigo_docente' => '34771707',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  30 => 
  array (
    'id' => 31,
    'user_id' => 74,
    'codigo_docente' => '34601123',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  31 => 
  array (
    'id' => 32,
    'user_id' => 75,
    'codigo_docente' => '1062297189',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  32 => 
  array (
    'id' => 33,
    'user_id' => 76,
    'codigo_docente' => '1062308210',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  33 => 
  array (
    'id' => 34,
    'user_id' => 77,
    'codigo_docente' => '76143191',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  34 => 
  array (
    'id' => 35,
    'user_id' => 78,
    'codigo_docente' => '34607546',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  35 => 
  array (
    'id' => 36,
    'user_id' => 79,
    'codigo_docente' => '1061430381',
    'genero_docente' => 'OTRO',
    'foto_docente' => 'default.png',
    'estado_docente' => '1',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
);

        foreach ($data as $row) {
            Docente::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
