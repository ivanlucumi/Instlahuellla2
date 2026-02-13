<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Rol;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Rol::where('nombre', 'SUPERADMIN')->first();
        $estudianteRole = Rol::where('nombre', 'ESTUDIANTE')->first();

        $adminRolId = $adminRole ? $adminRole->id : 1;
        $estudianteRolId = $estudianteRole ? $estudianteRole->id : 2;

         // 🔹 SUBMENÚ: INSTITUCION
        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Institución'],
            ['icono' => 'fa fa-id-badge', 'url' => 'admin.institucion.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 2]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Sedes'],
            ['icono' => 'fa fa-building', 'url' => 'admin.sede.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 3]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Docentes'],
            ['icono' => 'fa fa-chalkboard-teacher', 'url' => 'admin.docente.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 4]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Cursos'],
            ['icono' => 'fa fa-book', 'url' => 'admin.curso.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 5]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Hilos'],
            ['icono' => 'fa fa-stream', 'url' => 'admin.hilo.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 6]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Asignaturas'],
            ['icono' => 'fa fa-book-open', 'url' => 'admin.asignatura.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 7]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Grados Académicos'],
            ['icono' => 'fa fa-graduation-cap', 'url' => 'admin.gradoacademico.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 8]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Acudientes'],
            ['icono' => 'fa fa-user-friends', 'url' => 'admin.acudiente.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 9]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Estudiantes'],
            ['icono' => 'fa fa-user-graduate', 'url' => 'admin.estudiante.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 10]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Año Escolar'],
            ['icono' => 'fa fa-calendar-alt', 'url' => 'admin.anhoescolar.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 11]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Institución', 'nombre_submenu' => 'Periodos Académicos'],
            ['icono' => 'fa fa-calendar-check', 'url' => 'admin.periodoacademico.index', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 12]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Usuarios', 'nombre_submenu' => 'Crear'],
            ['icono' => 'fa fa-user-plus', 'url' => 'admin.usuarios.crear', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 13]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Usuarios', 'nombre_submenu' => 'Asignar Rol'],
            ['icono' => 'fa fa-id-badge', 'url' => 'admin.usuarios.asignarRol', 'tipo' => 'dropdown', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 14]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Matriculados'],
            ['icono' => 'fa fa-user-check', 'url' => 'admin.matriculado.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 15]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Notas'],
            ['icono' => 'fa fa-clipboard-list', 'url' => 'admin.notas.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 16]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Notas Definitivas'],
            ['icono' => 'fa fa-file-contract', 'url' => 'admin.notas-definitivas.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 17]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Notas Periodos'],
            ['icono' => 'fa fa-clipboard-list', 'url' => 'estudiante.notasPeriodo', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $estudianteRolId, 'orden' => 17]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Solicitar Paz y Salvo'],
            ['icono' => 'fa fa-clipboard-list', 'url' => 'estudiante.notasPeriodo', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $estudianteRolId, 'orden' => 17]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Solicitar Certificado Académico'],
            ['icono' => 'fa fa-file', 'url' => 'estudiante.notasPeriodo', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $estudianteRolId, 'orden' => 17]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Horario académico'],
            ['icono' => 'fa fa-calendar', 'url' => 'estudiante.notasPeriodo', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $estudianteRolId, 'orden' => 17]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Certificados'],
            ['icono' => 'fa fa-file', 'url' => 'admin.certificados.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 18]
        );

        Menu::updateOrCreate(
            ['nombre' => 'Paz y Salvo'],
            ['icono' => 'fa fa-file', 'url' => 'admin.pazysalvo.index', 'tipo' => 'sencillo', 'estado' => 1, 'rol_id' => $adminRolId, 'orden' => 19]
        );
    }
}
