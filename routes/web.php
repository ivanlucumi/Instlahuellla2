<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ruta principal agrupacion de rutas y middleware
Route::middleware(['auth', 'rol:SUPERADMIN,ADMIN'])
    ->prefix('home')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/usuarios/crear', [App\Http\Controllers\UsuarioController::class, 'crear'])->name('admin.usuarios.crear');
        Route::get('/usuarios/asignar-rol', [App\Http\Controllers\UsuarioController::class, 'asignarRol'])->name('admin.usuarios.asignarRol');

        Route::get('/institucion', [App\Http\Controllers\InstitucionController::class, 'Index'])->name('admin.institucion.index');
        Route::get('/institucion/crear', [App\Http\Controllers\InstitucionController::class, 'Create'])->name('admin.institucion.create');
        Route::post('/institucion', [App\Http\Controllers\InstitucionController::class, 'Store'])->name('admin.institucion.store');
        Route::get('/institucion/edit', [App\Http\Controllers\InstitucionController::class, 'Edit'])->name('admin.institucion.edit');
        Route::put('institucion/update/{id}', [App\Http\Controllers\InstitucionController::class, 'update'])
            ->name('admin.institucion.update');
        Route::get('/institucion/destroy', [App\Http\Controllers\InstitucionController::class, 'Destroy'])->name('admin.institucion.destroy');

        // Rutas para Sedes
        Route::get('/sede', [App\Http\Controllers\SedeController::class, 'index'])->name('admin.sede.index');
        Route::get('/sede/crear', [App\Http\Controllers\SedeController::class, 'create'])->name('admin.sede.create');
        Route::post('/sede', [App\Http\Controllers\SedeController::class, 'store'])->name('admin.sede.store');
        Route::get('/sede/{sede}/editar', [App\Http\Controllers\SedeController::class, 'edit'])->name('admin.sede.edit');
        Route::put('/sede/{sede}', [App\Http\Controllers\SedeController::class, 'update'])->name('admin.sede.update');
        Route::delete('/sede/{sede}', [App\Http\Controllers\SedeController::class, 'destroy'])->name('admin.sede.destroy');

        // Rutas para Docentes
        Route::get('/docente', [App\Http\Controllers\DocenteController::class, 'index'])->name('admin.docente.index');
        Route::get('/docente/crear', [App\Http\Controllers\DocenteController::class, 'create'])->name('admin.docente.create');
        Route::post('/docente', [App\Http\Controllers\DocenteController::class, 'store'])->name('admin.docente.store');
        Route::get('/docente/{docente}/editar', [App\Http\Controllers\DocenteController::class, 'edit'])->name('admin.docente.edit');
        Route::put('/docente/{docente}', [App\Http\Controllers\DocenteController::class, 'update'])->name('admin.docente.update');
        Route::delete('/docente/{docente}', [App\Http\Controllers\DocenteController::class, 'destroy'])->name('admin.docente.destroy');

        // Rutas para Cursos
        Route::get('/curso', [App\Http\Controllers\CursoController::class, 'index'])->name('admin.curso.index');
        Route::get('/curso/crear', [App\Http\Controllers\CursoController::class, 'create'])->name('admin.curso.create');
        Route::post('/curso', [App\Http\Controllers\CursoController::class, 'store'])->name('admin.curso.store');
        Route::get('/curso/{curso}/editar', [App\Http\Controllers\CursoController::class, 'edit'])->name('admin.curso.edit');
        Route::put('/curso/{curso}', [App\Http\Controllers\CursoController::class, 'update'])->name('admin.curso.update');
        Route::delete('/curso/{curso}', [App\Http\Controllers\CursoController::class, 'destroy'])->name('admin.curso.destroy');

        // Rutas para Hilos
        Route::get('/hilo', [App\Http\Controllers\HiloController::class, 'index'])->name('admin.hilo.index');
        Route::get('/hilo/crear', [App\Http\Controllers\HiloController::class, 'create'])->name('admin.hilo.create');
        Route::post('/hilo', [App\Http\Controllers\HiloController::class, 'store'])->name('admin.hilo.store');
        Route::get('/hilo/{hilo}/editar', [App\Http\Controllers\HiloController::class, 'edit'])->name('admin.hilo.edit');
        Route::put('/hilo/{hilo}', [App\Http\Controllers\HiloController::class, 'update'])->name('admin.hilo.update');
        Route::delete('/hilo/{hilo}', [App\Http\Controllers\HiloController::class, 'destroy'])->name('admin.hilo.destroy');

        // Rutas para Asignaturas
        Route::get('/asignatura', [App\Http\Controllers\AsignaturaController::class, 'index'])->name('admin.asignatura.index');
        Route::get('/asignatura/crear', [App\Http\Controllers\AsignaturaController::class, 'create'])->name('admin.asignatura.create');
        Route::post('/asignatura', [App\Http\Controllers\AsignaturaController::class, 'store'])->name('admin.asignatura.store');
        Route::get('/asignatura/{asignatura}/editar', [App\Http\Controllers\AsignaturaController::class, 'edit'])->name('admin.asignatura.edit');
        Route::put('/asignatura/{asignatura}', [App\Http\Controllers\AsignaturaController::class, 'update'])->name('admin.asignatura.update');
        Route::delete('/asignatura/{asignatura}', [App\Http\Controllers\AsignaturaController::class, 'destroy'])->name('admin.asignatura.destroy');

        // Rutas para Grados Académicos
        Route::get('/gradoacademico', [App\Http\Controllers\GradoAcademicoController::class, 'index'])->name('admin.gradoacademico.index');
        Route::get('/gradoacademico/crear', [App\Http\Controllers\GradoAcademicoController::class, 'create'])->name('admin.gradoacademico.create');
        Route::post('/gradoacademico', [App\Http\Controllers\GradoAcademicoController::class, 'store'])->name('admin.gradoacademico.store');
        Route::get('/gradoacademico/{gradoAcademico}', [App\Http\Controllers\GradoAcademicoController::class, 'show'])->name('admin.gradoacademico.show');
        Route::get('/gradoacademico/{gradoAcademico}/editar', [App\Http\Controllers\GradoAcademicoController::class, 'edit'])->name('admin.gradoacademico.edit');
        Route::put('/gradoacademico/{gradoAcademico}', [App\Http\Controllers\GradoAcademicoController::class, 'update'])->name('admin.gradoacademico.update');
        Route::delete('/gradoacademico/{gradoAcademico}', [App\Http\Controllers\GradoAcademicoController::class, 'destroy'])->name('admin.gradoacademico.destroy');

        // Rutas para Acudientes
        Route::get('/acudiente', [App\Http\Controllers\AcudienteController::class, 'index'])->name('admin.acudiente.index');
        Route::get('/acudiente/crear', [App\Http\Controllers\AcudienteController::class, 'create'])->name('admin.acudiente.create');
        Route::post('/acudiente', [App\Http\Controllers\AcudienteController::class, 'store'])->name('admin.acudiente.store');
        Route::get('/acudiente/{acudiente}/editar', [App\Http\Controllers\AcudienteController::class, 'edit'])->name('admin.acudiente.edit');
        Route::put('/acudiente/{acudiente}', [App\Http\Controllers\AcudienteController::class, 'update'])->name('admin.acudiente.update');
        Route::delete('/acudiente/{acudiente}', [App\Http\Controllers\AcudienteController::class, 'destroy'])->name('admin.acudiente.destroy');

        // Rutas para Estudiantes
        Route::get('/estudiante', [App\Http\Controllers\EstudianteController::class, 'index'])->name('admin.estudiante.index');
        Route::get('/estudiante/crear', [App\Http\Controllers\EstudianteController::class, 'create'])->name('admin.estudiante.create');
        Route::post('/estudiante', [App\Http\Controllers\EstudianteController::class, 'store'])->name('admin.estudiante.store');
        Route::get('/estudiante/{estudiante}/editar', [App\Http\Controllers\EstudianteController::class, 'edit'])->name('admin.estudiante.edit');
        Route::put('/estudiante/{estudiante}', [App\Http\Controllers\EstudianteController::class, 'update'])->name('admin.estudiante.update');
        Route::delete('/estudiante/{estudiante}', [App\Http\Controllers\EstudianteController::class, 'destroy'])->name('admin.estudiante.destroy');

        // Rutas para Año Escolar
        Route::get('/anho-escolar', [App\Http\Controllers\AnhoEscolarController::class, 'index'])->name('admin.anhoescolar.index');
        Route::get('/anho-escolar/crear', [App\Http\Controllers\AnhoEscolarController::class, 'create'])->name('admin.anhoescolar.create');
        Route::post('/anho-escolar', [App\Http\Controllers\AnhoEscolarController::class, 'store'])->name('admin.anhoescolar.store');
        Route::get('/anho-escolar/{anhoEscolar}/editar', [App\Http\Controllers\AnhoEscolarController::class, 'edit'])->name('admin.anhoescolar.edit');
        Route::put('/anho-escolar/{anhoEscolar}', [App\Http\Controllers\AnhoEscolarController::class, 'update'])->name('admin.anhoescolar.update');
        Route::delete('/anho-escolar/{anhoEscolar}', [App\Http\Controllers\AnhoEscolarController::class, 'destroy'])->name('admin.anhoescolar.destroy');

        // Rutas para Periodo Académico
        Route::get('/periodo-academico', [App\Http\Controllers\PeriodoAcademicoController::class, 'index'])->name('admin.periodoacademico.index');
        Route::get('/periodo-academico/crear', [App\Http\Controllers\PeriodoAcademicoController::class, 'create'])->name('admin.periodoacademico.create');
        Route::post('/periodo-academico', [App\Http\Controllers\PeriodoAcademicoController::class, 'store'])->name('admin.periodoacademico.store');
        Route::get('/periodo-academico/{periodoAcademico}/editar', [App\Http\Controllers\PeriodoAcademicoController::class, 'edit'])->name('admin.periodoacademico.edit');
        Route::put('/periodo-academico/{periodoAcademico}', [App\Http\Controllers\PeriodoAcademicoController::class, 'update'])->name('admin.periodoacademico.update');
        Route::delete('/periodo-academico/{periodoAcademico}', [App\Http\Controllers\PeriodoAcademicoController::class, 'destroy'])->name('admin.periodoacademico.destroy');

        // Rutas de Creación Rápida (Mantener para compatibilidad)
        Route::post('/estudiante/store-quick', [App\Http\Controllers\EstudianteController::class, 'storeQuick'])->name('admin.estudiante.store-quick');
        Route::post('/acudiente/store-quick', [App\Http\Controllers\AcudienteController::class, 'storeQuick'])->name('admin.acudiente.store-quick');
        Route::post('/asignatura/store-quick', [App\Http\Controllers\AsignaturaController::class, 'storeQuick'])->name('admin.asignatura.store-quick');
        Route::post('/gradoacademico/store-quick', [App\Http\Controllers\GradoAcademicoController::class, 'storeQuick'])->name('admin.gradoacademico.store-quick');
        Route::post('/anho-escolar/store-quick', [App\Http\Controllers\AnhoEscolarController::class, 'storeQuick'])->name('admin.anhoescolar.store-quick');

        // Rutas para obtener listas (al refrescar los selects tras crear en nueva ventana)
        Route::get('/estudiante/list', [App\Http\Controllers\EstudianteController::class, 'list'])->name('admin.estudiante.list');
        Route::get('/acudiente/list', [App\Http\Controllers\AcudienteController::class, 'list'])->name('admin.acudiente.list');
        Route::get('/asignatura/list', [App\Http\Controllers\AsignaturaController::class, 'list'])->name('admin.asignatura.list');
        Route::get('/gradoacademico/list', [App\Http\Controllers\GradoAcademicoController::class, 'list'])->name('admin.gradoacademico.list');
        Route::get('/anho-escolar/list', [App\Http\Controllers\AnhoEscolarController::class, 'list'])->name('admin.anhoescolar.list');

        // Rutas para Matriculado
        Route::resource('matriculado', App\Http\Controllers\MatriculadoController::class)->names('admin.matriculado');

        // Rutas para Notas
        Route::resource('notas', App\Http\Controllers\NotasController::class)->names('admin.notas');

        // Rutas para Notas Definitivas (Histórico)
        Route::resource('notas-definitivas', App\Http\Controllers\NotasDefinitivasController::class)->names('admin.notas-definitivas');

        // Rutas para Auditoría
        Route::get('/auditoria', [App\Http\Controllers\AuditController::class, 'index'])->name('admin.audit.index');

        // Rutas para Certificados de Notas
        Route::get('/certificados', [App\Http\Controllers\CertificadoController::class, 'index'])->name('admin.certificados.index');
        Route::get('/certificados/generar', [App\Http\Controllers\CertificadoController::class, 'generar'])->name('admin.certificados.generar');

        // Rutas para Paz y Salvo
        Route::get('/pazysalvo', [App\Http\Controllers\PazYSalvoController::class, 'index'])->name('admin.pazysalvo.index');
        Route::get('/pazysalvo/generar', [App\Http\Controllers\PazYSalvoController::class, 'generar'])->name('admin.pazysalvo.generar');
    });

Route::middleware(['auth', 'rol:ESTUDIANTE'])
    ->prefix('estudiante')
    ->group(function () {

        Route::get('/notasperiodo', [App\Http\Controllers\EstudianteController::class, 'notasPeriodo'])
            ->name('estudiante.notasPeriodo');
    });

Route::middleware(['auth','rol:SUPERADMIN,ADMIN,DOCENTE'])
    ->prefix('docente')
    ->group(function () {

    Route::get('/asignatura_docente', [App\Http\Controllers\DocenteController::class, 'asignaturaDocente'])
            ->name('docente.dashboard');

    Route::get('/asignatura_grado', [App\Http\Controllers\DocenteController::class, 'asignatura_grado_docente'])
            ->name('docente.asignatura_grado');

    Route::get('/docente/grado/{grado}/listado', [App\Http\Controllers\DocenteController::class, 'listadoClases'])->name('docente.listado.clases');

    Route::get('/calificacicar', [App\Http\Controllers\DocenteController::class, 'listaCalificarEstudiante'])->name('docente.calificar.estudiantes');    
    Route::get('/docente/grado/{grado}/calificar', [App\Http\Controllers\DocenteController::class, 'calificarEstudianteFinal'])->name('docente.listado.calificar');
    Route::post('/docente/guardar-notas', [App\Http\Controllers\DocenteController::class, 'guardarNotas'])->name('docente.guardarNotas');

    // Nuevas rutas solicitadas
    Route::get('/asignatura/{asignatura}/{grado}/estudiantes', [App\Http\Controllers\DocenteController::class, 'estudiantesAsignatura'])->name('docente.asignatura.estudiantes');
    Route::post('/notas/update', [App\Http\Controllers\DocenteController::class, 'updateNotas'])->name('docente.notas.update');
    Route::post('/estudiantes/promover', [App\Http\Controllers\DocenteController::class, 'promoverEstudiantes'])->name('docente.estudiantes.promover');
});


