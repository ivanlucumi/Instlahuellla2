<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Acudiente;
use App\Models\Sede;
use App\Models\Hilo;
use App\Models\Curso;
use App\Models\GradoAcademico;
use App\Models\Asignatura;
use App\Models\Matriculado;
use App\Models\AnhoEscolar;
use App\Models\Institucion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function() {
            // 1. Rector User (Required for Institution)
            $rolRector = Rol::where('nombre', 'RECTOR')->first();
            $userRector = User::updateOrCreate(['email' => 'rector@instlahuella.com'], [
                'name' => 'Rector de Prueba',
                'password' => Hash::make('password123'),
                'genero' => 'Masculino'
            ]);
            if ($rolRector && !$userRector->roles()->where('nombre', 'RECTOR')->exists()) {
                $userRector->roles()->attach($rolRector->id);
            }

            // 2. Institución
            $institucion = Institucion::updateOrCreate(['nombre_institucion' => 'Inst La Huella'], [
                'descripcion_institucion' => 'Institución Educativa de Prueba',
                'codigo_dane' => '12345678',
                'ciudad_institucion' => 'Cali',
                'departamento_institucion' => 'Valle',
                'resolucion_institucion' => 'Res 001',
                'rector_id' => $userRector->id
            ]);

            // 3. Usuario Docente
            $rolDocente = Rol::where('nombre', 'DOCENTE')->first();
            $userDocente = User::updateOrCreate(['email' => 'docente@instlahuella.com'], [
                'name' => 'Profesor de Prueba',
                'password' => Hash::make('password123'),
                'genero' => 'Masculino'
            ]);
            
            if ($rolDocente && !$userDocente->roles()->where('nombre', 'DOCENTE')->exists()) {
                $userDocente->roles()->attach($rolDocente->id);
            }

            $docente = Docente::updateOrCreate(['user_id' => $userDocente->id], [
                'codigo_docente' => 'DOC001',
                'genero_docente' => 'Masculino',
                'foto_docente' => 'default.png',
                'estado_docente' => true
            ]);

            // 4. Sede
            $sede = Sede::updateOrCreate(['nombre_sede' => 'Sede Principal'], [
                'descripcion_sede' => 'Sede Principal Académica',
                'codigo_dane_sede' => '12345678-01',
                'resolucion_sede' => 'Res 002',
                'institucion_id' => $institucion->id,
                'estado_sede' => true
            ]);

            // 5. Hilo
            $hilo = Hilo::updateOrCreate(['nombre_hilo' => 'Académico'], [
                'abreviatura' => 'ACAD',
                'estado' => 'activo'
            ]);

            // 6. Curso
            $curso = Curso::updateOrCreate(['nombre_curso' => 'A'], [
                'descripcion' => 'Curso A Mañana',
                'estado' => 'activo'
            ]);

            // 7. Año Escolar
            $anho = AnhoEscolar::updateOrCreate(['nombre_anho_escolar' => '2026'], [
                'fecha_inicio_anho_escolar' => '2026-01-20',
                'fecha_fin_anho_escolar' => '2026-11-30',
                'estado_anho_escolar' => true,
                'descripcion_anho_escolar' => 'Año escolar de prueba 2026'
            ]);

            // 8. Grados
            $grado10 = GradoAcademico::updateOrCreate(['nombre_grado' => 'Décimo', 'bloque' => 'A'], [
                'sede_id' => $sede->id,
                'curso_id' => $curso->id,
                'docente_id' => $docente->id,
                'estado_grado_academico' => true
            ]);

            $grado11 = GradoAcademico::updateOrCreate(['nombre_grado' => 'Once', 'bloque' => 'A'], [
                'sede_id' => $sede->id,
                'curso_id' => $curso->id,
                'docente_id' => $docente->id,
                'estado_grado_academico' => true
            ]);

            // 9. Asignatura
            $asignatura = Asignatura::updateOrCreate(['nombre_asignatura' => 'Matemáticas', 'sede_id' => $sede->id], [
                'hilo_id' => $hilo->id,
                'descripcion' => 'Cálculo y Álgebra',
                'creditos' => 4,
                'docente_id' => $userDocente->id,
                'nivel_educativo' => 'secundaria',
                'estado' => 'activo'
            ]);

            // 10. Acudiente
            $userAcudiente = User::updateOrCreate(['email' => 'acudiente@prueba.com'], [
                'name' => 'Acudiente de Prueba',
                'password' => Hash::make('password123'),
                'genero' => 'Femenino'
            ]);
            $acudiente = Acudiente::updateOrCreate(['user_id' => $userAcudiente->id], [
                'celular_acudiente' => '3101234567',
                'direccion_acudiente' => 'Calle 10 #20-30',
                'genero_acudiente' => 'Femenino',
                'parentesco_acudiente' => 'Madre',
                'estado_acudiente' => true
            ]);

            // 11. Estudiantes
            $rolEstudiante = Rol::where('nombre', 'ESTUDIANTE')->first();
            
            for ($i = 1; $i <= 5; $i++) {
                $email = "estudiante{$i}@prueba.com";
                $userEst = User::updateOrCreate(['email' => $email], [
                    'name' => "Estudiante Prueba {$i}",
                    'password' => Hash::make('password123'),
                    'genero' => $i % 2 == 0 ? 'Femenino' : 'Masculino'
                ]);

                if ($rolEstudiante && !$userEst->roles()->where('nombre', 'ESTUDIANTE')->exists()) {
                    $userEst->roles()->attach($rolEstudiante->id);
                }

                $estudiante = Estudiante::updateOrCreate(['user_id' => $userEst->id], [
                    'codigo_estudiante' => "EST00{$i}",
                    'fecha_nacimiento_estudiante' => '2010-05-15',
                    'genero_estudiante' => $userEst->genero,
                    'foto_estudiante' => 'default.png',
                    'anho_curso_estudiante' => '2026',
                    'direccion_estudiante' => 'Dirección de prueba',
                    'telefono_estudiante' => '7654321',
                    'email_estudiante' => $userEst->email,
                    'tipo_identificacion_estudiante' => 'Tarjeta de Identidad',
                    'numero_identificacion_estudiante' => "1000{$i}",
                    'estado_estudiante' => true,
                    'acudiente_id' => $acudiente->id,
                    'grado_academico_id' => $grado10->id,
                ]);

                // 12. Matricular en la asignatura
                Matriculado::updateOrCreate([
                    'estudiante_id' => $estudiante->id,
                    'asignatura_id' => $asignatura->id,
                    'grado_id' => $grado10->id,
                    'anho_escolar_id' => $anho->id
                ], [
                    'acudiente_id' => $acudiente->id,
                    'estado' => 'activo',
                    'fecha_matricula' => now()
                ]);
            }
        });
    }
}
