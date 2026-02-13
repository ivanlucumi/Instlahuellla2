<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::updateOrCreate(
            ['id' => 1],
            [
                'nombre' => 'SUPERADMIN',
                'descripcion' => 'Administrador del sistema'
            ]
        );

        Rol::updateOrCreate(
            ['id' => 2],
            [
                'nombre' => 'ESTUDIANTE',
                'descripcion' => 'Estudiante de colegio'
            ]
        );

        Rol::updateOrCreate(
            ['id' => 3],
            [
                'nombre' => 'RECTOR',
                'descripcion' => 'Rector de colegio'
            ]
        );

        
        Rol::updateOrCreate(
            ['id' => 4],
            [
                'nombre' => 'DOCENTE',
                'descripcion' => 'Docente de colegio'
            ]
        );
    }
}
