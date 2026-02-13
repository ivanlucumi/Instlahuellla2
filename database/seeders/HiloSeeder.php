<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hilo;

class HiloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hilos = [
            [
                'nombre_hilo' => 'GOBIERNO PROPIO',
                'abreviatura' => 'KHABU WEJXIA',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'MADRE TIERRA',
                'abreviatura' => 'UMA KIWE',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'ARTÍSTICO Y CULTURAL',
                'abreviatura' => 'YAT YUWE',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'ARMONÍA Y EQUILIBRIO',
                'abreviatura' => 'CXACXAHAPHI',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'PENSAMIENTO MATEMÁTICO',
                'abreviatura' => 'A´PTEPA´KA',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'COMUNICACIÓN COMUNITARIA',
                'abreviatura' => 'YUWEKIPNAKA',
                'estado'      => 'activo'
            ],
            [
                'nombre_hilo' => 'TECNOLOGÍA E INFORMÁTICA',
                'abreviatura' => 'SKHAY YUWE',
                'estado'      => 'activo'
            ],
        ];

        foreach ($hilos as $hilo) {
            Hilo::updateOrCreate(
                ['nombre_hilo' => $hilo['nombre_hilo']], // Clave para buscar y evitar duplicados
                $hilo
            );
        }
    }
}
