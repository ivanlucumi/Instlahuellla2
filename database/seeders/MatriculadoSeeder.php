<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Matriculado;

class MatriculadoSeeder extends Seeder
{
    public function run(): void
    {
        $data = array (
);

        foreach ($data as $row) {
            Matriculado::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
