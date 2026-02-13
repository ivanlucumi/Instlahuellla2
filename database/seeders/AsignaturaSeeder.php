<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asignatura;
use App\Models\Hilo;
use App\Models\Sede;
use App\Models\User;
use App\Models\Institucion;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que existe una institución y sede para la relación
        $institucion = Institucion::firstOrCreate(
            ['nombre_institucion' => 'INSTITUCIÓN EDUCATIVA LA HUELLA'],
            [
                'descripcion_institucion' => 'Descripción de la institución',
                'codigo_dane' => '123456789',
                'ciudad_institucion' => 'Ciudad',
                'departamento_institucion' => 'Departamento',
                'resolucion_institucion' => 'Resolución 001',
                'rector_id' => 3, // Rector (id 3 from UserSeeder)
            ]
        );

        $sede = Sede::firstOrCreate(
            ['nombre_sede' => 'SEDE PRINCIPAL'],
            [
                'descripcion_sede' => 'Sede central de la institución',
                'codigo_dane_sede' => '123456789-1',
                'resolucion_sede' => 'Resolución 002',
                'institucion_id' => $institucion->id,
                'estado_sede' => true
            ]
        );

        // Docente por defecto (según UserSeeder id 4 es Docente)
        $docente = User::where('name', 'Docente')->first() ?? User::first();

        // Mapeo de asignaturas con su hilo y nivel educativo
        // primaria: grados 1-5, secundaria: grados 6-11
        $mapping = [
            'CIENCIAS NATURALES' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'MATEMÁTICAS' => ['hilo' => 'PENSAMIENTO MATEMÁTICO', 'nivel' => 'secundaria'],
            'LENGUA CASTELLANA' => ['hilo' => 'COMUNICACIÓN COMUNITARIA', 'nivel' => 'secundaria'],
            'EDUCACIÓN FÍSICA' => ['hilo' => 'ARMONÍA Y EQUILIBRIO', 'nivel' => 'secundaria'],
            'ARTÍSTICO Y CULTURAL' => ['hilo' => 'ARTÍSTICO Y CULTURAL', 'nivel' => 'secundaria'],
            'ETICA Y VALORES' => ['hilo' => 'ARMONÍA Y EQUILIBRIO', 'nivel' => 'secundaria'],
            'TECNOLOGÍA E INFORMÁTICA' => ['hilo' => 'TECNOLOGÍA E INFORMÁTICA', 'nivel' => 'secundaria'],
            'DEMOCRACIA' => ['hilo' => 'GOBIERNO PROPIO', 'nivel' => 'secundaria'],
            'JU´ GNTHEWESX PTÜUSENXI´S' => ['hilo' => 'COMUNICACIÓN COMUNITARIA', 'nivel' => 'secundaria'],
            'ALGEBRA' => ['hilo' => 'PENSAMIENTO MATEMÁTICO', 'nivel' => 'secundaria'],
            'GEOMETRÍA' => ['hilo' => 'PENSAMIENTO MATEMÁTICO', 'nivel' => 'secundaria'],
            'ESTADÍSTICA' => ['hilo' => 'PENSAMIENTO MATEMÁTICO', 'nivel' => 'secundaria'],
            'TRIGONOMETRÍA' => ['hilo' => 'PENSAMIENTO MATEMÁTICO', 'nivel' => 'secundaria'],
            'BIOLOGIA' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'FISICA' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'QUIMICA' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'AGROPECUARIAS' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'PROYECTOS' => ['hilo' => 'MADRE TIERRA', 'nivel' => 'secundaria'],
            'FILOSOFIA' => ['hilo' => 'GOBIERNO PROPIO', 'nivel' => 'secundaria'],
            'HISTORIA' => ['hilo' => 'GOBIERNO PROPIO', 'nivel' => 'secundaria'],
            'GEOGRAFIA' => ['hilo' => 'GOBIERNO PROPIO', 'nivel' => 'secundaria'],
            'INGLÉS' => ['hilo' => 'COMUNICACIÓN COMUNITARIA', 'nivel' => 'secundaria'],
        ];

        foreach ($mapping as $asignaturaNombre => $data) {
            $hilo = Hilo::where('nombre_hilo', $data['hilo'])->first();

            if ($hilo) {
                Asignatura::updateOrCreate(
                    ['nombre_asignatura' => $asignaturaNombre],
                    [
                        'nivel_educativo' => $data['nivel'],
                        'sede_id' => $sede->id,
                        'hilo_id' => $hilo->id,
                        'descripcion' => 'Asignatura de ' . $data['nivel'] . ' perteneciente al hilo ' . $data['hilo'],
                        'creditos' => 'Sin definir',
                        'docente_id' => $docente->id,
                        'estado' => 'activo',
                    ]
                );
            }
        }
    }
}
