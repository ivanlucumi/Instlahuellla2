<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\GradoAcademico;
use App\Models\Matriculado;
use App\Models\Notas;
use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Models\AnhoEscolar;
use Illuminate\Http\Request;

class DocenteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Docente::with('user')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('codigo_docente', 'LIKE', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
                  });
            });
        }

        if ($request->filled('genero')) {
            $query->where('genero_docente', $request->genero);
        }

        $perPage = $request->get('per_page', 10);
        $docentes = $query->paginate($perPage)->appends($request->all());

        return view('Docente.Index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para crear registros. Solo roles directivos pueden hacerlo.');

        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('Docente.Create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        // 🔒 Validación
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'codigo_docente'  => 'required|string|unique:docentes,codigo_docente',
            'genero_docente'  => 'required|string',
            'foto_docente'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado_docente'  => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request) {
            // 1. Crear Usuario
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => \Hash::make('Temporal123'),
                'genero'   => $request->genero_docente, // Usamos el mismo género
            ]);

            // 2. Asignar Rol DOCENTE
            $rolDocente = \App\Models\Rol::where('nombre', 'DOCENTE')->first();
            if ($rolDocente) {
                $user->roles()->attach($rolDocente->id);
            }

            // 3. Manejo de foto
            $fotoPath = null;
            if ($request->hasFile('foto_docente')) {
                $fotoPath = $request->file('foto_docente')->store('docentes', 'public');
            }

            // 4. Crear Docente
            Docente::create([
                'user_id'        => $user->id,
                'codigo_docente' => $request->codigo_docente,
                'genero_docente' => $request->genero_docente,
                'foto_docente'   => $fotoPath ?? 'default.png',
                'estado_docente' => $request->has('estado_docente') ? true : false,
            ]);
        });

        // ✅ Éxito
        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El docente y su usuario fueron registrados correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        // No necesitamos lista de usuarios, ya editamos el propio
        return view('Docente.Edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        // 🔒 Validación
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $docente->user_id,
            'password'        => 'nullable|string|min:8',
            'codigo_docente'  => 'required|string|unique:docentes,codigo_docente,' . $docente->id,
            'genero_docente'  => 'required|string',
            'foto_docente'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado_docente'  => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request, $docente) {
            // 1. Actualizar Usuario
            $userData = [
                'name'   => $request->name,
                'email'  => $request->email,
                'genero' => $request->genero_docente,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = \Hash::make($request->password);
            }
            
            $docente->user->update($userData);

            // 2. Manejo de foto
            $fotoPath = $docente->foto_docente;
            if ($request->hasFile('foto_docente')) {
                if ($docente->foto_docente && $docente->foto_docente !== 'default.png') {
                    \Storage::disk('public')->delete($docente->foto_docente);
                }
                $fotoPath = $request->file('foto_docente')->store('docentes', 'public');
            }

            // 3. Actualizar Docente
            $docente->update([
                'codigo_docente' => $request->codigo_docente,
                'genero_docente' => $request->genero_docente,
                'foto_docente'   => $fotoPath,
                'estado_docente' => $request->has('estado_docente') ? true : false,
            ]);
        });

        // ✅ Éxito
        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El docente y su usuario de acceso fueron actualizados correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        // Eliminar foto si existe y no es la default
        if ($docente->foto_docente && $docente->foto_docente !== 'default.png') {
            \Storage::disk('public')->delete($docente->foto_docente);
        }

        $docente->delete();

        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El docente fue eliminado correctamente.'
        ]);
    }


    public function asignaturaDocente()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
        $isDirector = $user->hasRol('DIRECTOR');
        $docenteId = $user->docente->id ?? null;

        if ($isSuperAdmin) {
            // SuperAdmin/Admin ve todas las asignaciones de todos los docentes
            $gradosConMaterias = GradoAcademico::with(['asignaturas' => function($q) {
                $q->with(['hilo', 'docentes']);
            }])->get();
        } else {
            // El docente ve:
            // 1. Sus propias materias (en cualquier grado)
            // 2. Si es director, TODAS las materias de los grados que dirige
            $gradosDirigidosIds = $isDirector ? GradoAcademico::where('docente_id', $docenteId)->pluck('id')->toArray() : [];
            
            $gradosConMaterias = GradoAcademico::where(function($query) use ($user, $gradosDirigidosIds) {
                $query->whereIn('id', $gradosDirigidosIds)
                      ->orWhereHas('asignaturas', function($q) use ($user) {
                          $q->where('asignatura_grado_docente.docente_id', $user->id);
                      });
            })->with(['asignaturas' => function($q) use ($user, $gradosDirigidosIds) {
                $q->with('hilo');
            }])->get();
        }

        // Aplanamos para la vista
        $assignments = collect();
        foreach ($gradosConMaterias as $grado) {
            $esDirigido = $isDirector && $grado->docente_id == $docenteId;
            
            foreach ($grado->asignaturas as $asig) {
                // Buscamos quién es el docente de esta materia en este grado
                $pivot = \DB::table('asignatura_grado_docente')
                    ->where('grado_academico_id', $grado->id)
                    ->where('asignatura_id', $asig->id)
                    ->first();
                
                $docenteDeLaMateriaId = $pivot->docente_id ?? null;
                $puedeVer = $isSuperAdmin || $esDirigido || ($docenteDeLaMateriaId == $user->id);

                if ($puedeVer) {
                    $docenteNombre = 'N/A';
                    if ($docenteDeLaMateriaId) {
                        $u = \App\Models\User::find($docenteDeLaMateriaId);
                        $docenteNombre = $u ? $u->name : 'N/A';
                    }

                    $assignments->push((object)[
                        'id'                => $asig->id,
                        'nombre_asignatura' => $asig->nombre_asignatura,
                        'hilo_nombre'       => $asig->hilo->nombre_hilo ?? 'N/A',
                        'grado_id'          => $grado->id,
                        'grado_nombre'      => $grado->nombre_grado . ' - ' . $grado->bloque,
                        'docente_nombre'    => $docenteNombre,
                    ]);
                }
            }
        }

        // Extra: Módulo Grado Cero como "Asignatura" Virtual
        if (!$isSuperAdmin && $docenteId && $user->hasRol('DOCENTE')) {
            $gradosCero = GradoAcademico::where('docente_id', $docenteId)
                ->where('nombre_grado', 'CERO')
                ->get();

            foreach ($gradosCero as $gc) {
                // Agregar ID virtual para evitar choques con asignaturas reales
                $assignments->push((object)[
                    'id'                => 'grado_cero_' . $gc->id, 
                    'nombre_asignatura' => '<span class="badge bg-warning text-dark"><i class="fa fa-child"></i> Módulo Transición (Grado Cero)</span>',
                    'hilo_nombre'       => 'Evaluación Integral',
                    'grado_id'          => $gc->id,
                    'grado_nombre'      => $gc->nombre_grado . ' - ' . $gc->bloque,
                    'docente_nombre'    => $user->name,
                    'is_virtual_grado_cero' => true // Flag for the view
                ]);
            }
        }

        $institucion = \App\Models\Institucion::first();

        // Agrupar asignaturas por nombre_grado para mejor organización visual
        $groupedAssignments = $assignments->groupBy('grado_nombre');

        return view('Docente.asignatura.asignatura_docente', compact('groupedAssignments', 'assignments', 'isSuperAdmin', 'isDirector', 'institucion'));
    }

    public function estudiantesAsignatura($asignaturaId, $gradoId)
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
        
        // Permisos: SuperAdmin, Director del Grado o Docente asignado a la materia
        $isDirectorOfThisGrade = GradoAcademico::where('id', $gradoId)
            ->where('docente_id', $user->docente->id ?? null)
            ->exists();
        
        $isAssignedTeacher = \DB::table('asignatura_grado_docente')
            ->where('grado_academico_id', $gradoId)
            ->where('asignatura_id', $asignaturaId)
            ->where('docente_id', $user->id)
            ->exists();

        if (!$isSuperAdmin && !$isDirectorOfThisGrade && !$isAssignedTeacher) {
            abort(403, 'No tiene permisos para ver los estudiantes o notas de esta asignatura.');
        }

        // ¿Puede editar? Solo si es SuperAdmin o el Docente Asignado
        $canEdit = $isSuperAdmin || $isAssignedTeacher;

        $asignatura = Asignatura::with(['hilo'])->findOrFail($asignaturaId);
        $grado = GradoAcademico::findOrFail($gradoId);
        
        $currentAnhoObj = AnhoEscolar::where('estado_anho_escolar', 1)->first();
        $anoLectivo = request('ano_lectivo') ?: ($currentAnhoObj?->nombre_anho_escolar ?? date('Y'));
        
        $esAnoActual = $currentAnhoObj && ($currentAnhoObj->nombre_anho_escolar == $anoLectivo);

        // Obtener documentos de estudiantes desde MatriculaFinal
        $documentos = \App\Models\MatriculaFinal::where('id_grado', $gradoId)
            ->where('ano_lectivo', $anoLectivo)
            ->pluck('documento_estudiante');

        $estudiantes = Estudiante::with(['user'])
        ->whereIn('numero_identificacion_estudiante', $documentos)
        ->get();

        // Cargar las notas directas desde NotasDefinitivas para AMBOS (actual e historico)
        $notasDefinitivas = \App\Models\NotasDefinitivas::where('asignatura_id', $asignaturaId)
            ->whereIn('documento_estudiante', $documentos)
            ->where('grado_aprobado', 'like', "%{$grado->nombre_grado}%")
            ->get();
        
        foreach ($estudiantes as $est) {
            if ($esAnoActual) {
                $matriculaFinal = \App\Models\MatriculaFinal::where('documento_estudiante', $est->numero_identificacion_estudiante)
                    ->where('ano_lectivo', $anoLectivo)
                    ->first();
                if ($matriculaFinal) {
                    $nd = \App\Models\NotasDefinitivas::where('id_matricula', $matriculaFinal->id)
                        ->where('asignatura_id', $asignaturaId)
                        ->first();
                } else {
                    $nd = null;
                }
            } else {
                $nd = $notasDefinitivas->where('documento_estudiante', $est->numero_identificacion_estudiante)->first();
            }

            // Crear un objeto que imite el modelo Notas para que la vista funcione
            $mockNota = (object)[
                'nota1' => $nd->nota_per1 ?? null,
                'nota2' => $nd->nota_per2 ?? null,
                'nota3' => $nd->nota_per3 ?? null,
                'nota4' => $nd->nota_per4 ?? null,
                'nota_definitiva' => $nd->nota_definitiva ?? null,
                'observaciones' => $nd->observaciones ?? ($esAnoActual ? '' : 'Registro Histórico (' . $anoLectivo . ')')
            ];
            $est->setRelation('notas', collect([$mockNota]));
        }

        $all_graded = $estudiantes->isNotEmpty();
        foreach ($estudiantes as $estudiante) {
            $nota = $estudiante->notas->first();
            if (!$nota || $nota->nota_definitiva === null || $nota->nota_definitiva == 0) {
                $all_graded = false;
                break;
            }
        }

        $todosLosGrados = GradoAcademico::all();
        $anhosEscolares = AnhoEscolar::all();

        return view('Docente.asignatura.estudiantes_asignatura', compact(
            'asignatura', 
            'grado', 
            'estudiantes', 
            'todosLosGrados', 
            'all_graded',
            'esAnoActual',
            'anoLectivo',
            'canEdit',
            'anhosEscolares'
        ));
    }

    public function updateNotas(Request $request)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id'      => 'required|exists:grado_academicos,id',
            'notas'         => 'required|array',
        ]);

        $user = auth()->user();
        $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
        
        $isAssignedTeacher = \DB::table('asignatura_grado_docente')
            ->where('grado_academico_id', $request->grado_id)
            ->where('asignatura_id', $request->asignatura_id)
            ->where('docente_id', $user->id)
            ->exists();

        if (!$isSuperAdmin && !$isAssignedTeacher) {
            abort(403, 'No tiene permisos para modificar las calificaciones de esta asignatura.');
        }

        $anhoEscolarId = AnhoEscolar::where('estado_anho_escolar', 1)
            ->orderBy('nombre_anho_escolar', 'desc')
            ->first()?->id ?? 1; // Fallback to 1 if none active

        $gradoOficial = GradoAcademico::find($request->grado_id);
        $esGradoCero = $gradoOficial && (
            str_contains(strtoupper($gradoOficial->nombre_grado), 'CERO') || 
            str_contains(strtoupper($gradoOficial->nombre_grado), 'TRANSICION')
        );

        $errors = [];
        $savedCount = 0;

        foreach ($request->notas as $estudianteId => $notasData) {
            $nota1 = $notasData['nota1'] ?? 0;
            $nota2 = $notasData['nota2'] ?? 0;
            $nota3 = $notasData['nota3'] ?? 0;
            $nota4 = $notasData['nota4'] ?? 0;
            $observaciones = $notasData['observaciones'] ?? null;

            if ($nota1 === null && $nota2 === null && $nota3 === null && $nota4 === null) {
                continue;
            }

            $estudiante = Estudiante::findOrFail($estudianteId);
            
            // Buscar la matrícula oficial del estudiante en este año y grado
            $matriculaFinal = \App\Models\MatriculaFinal::where('documento_estudiante', $estudiante->numero_identificacion_estudiante)
                ->where('id_grado', $request->grado_id)
                ->where('ano_lectivo', ($anhoEscolarObj->nombre_anho_escolar ?? date('Y')))
                ->first();

            if (!$matriculaFinal) {
                $errors[] = "El estudiante $nombre no tiene registro oficial de matrícula actual en este grado.";
                continue;
            }

            // Calcular definitiva: solo promedia cuando se califique el 3er periodo
            $n1 = is_numeric($nota1) && $nota1 > 0 ? (float)$nota1 : 0;
            $n2 = is_numeric($nota2) && $nota2 > 0 ? (float)$nota2 : 0;
            $n3 = is_numeric($nota3) && $nota3 > 0 ? (float)$nota3 : 0;
            $n4 = is_numeric($nota4) && $nota4 > 0 ? (float)$nota4 : 0;

            $definitiva = 0;
            if ($n3 > 0) {
                if ($n4 > 0) {
                    $definitiva = ($n1 + $n2 + $n3 + $n4) / 4;
                } else {
                    $definitiva = ($n1 + $n2 + $n3) / 3;
                }
            }

            // --- BLOQUEO DE EDICIÓN ---
            $isAdmin = auth()->user()->hasRol('SUPERADMIN') || auth()->user()->hasRol('RECTOR');
            $oldNota = \App\Models\NotasDefinitivas::where('id_matricula', $matriculaFinal->id)
                            ->where('asignatura_id', $request->asignatura_id)
                            ->first();

            if ($oldNota && !$isAdmin) {
                // Si la nota ya existe y no es admin, mantenemos lo anterior si tenía valor
                if ($oldNota->nota_per1 > 0) $nota1 = $oldNota->nota_per1;
                if ($oldNota->nota_per2 > 0) $nota2 = $oldNota->nota_per2;
                if ($oldNota->nota_per3 > 0) $nota3 = $oldNota->nota_per3;
                if ($oldNota->nota_per4 > 0) $nota4 = $oldNota->nota4;
                if (!empty($oldNota->observaciones)) $observaciones = $oldNota->observaciones;

                // Recalcular definitiva con los valores bloqueados
                $n1 = (float)$nota1; $n2 = (float)$nota2; $n3 = (float)$nota3; $n4 = (float)$nota4;
                $definitiva = 0;
                if ($n3 > 0) {
                    if ($n4 > 0) $definitiva = ($n1 + $n2 + $n3 + $n4) / 4;
                    else $definitiva = ($n1 + $n2 + $n3) / 3;
                }
            }
            // --------------------------

            // --- VALIDACIÓN SECUENCIAL (Backend) ---
            if (!$isAdmin) {
                // Comprobar secuencia (P4 requiere P3, P3 requiere P2, P2 requiere P1)
                $n1 = is_numeric($nota1) && $nota1 > 0 ? (float)$nota1 : 0;
                $n2 = is_numeric($nota2) && $nota2 > 0 ? (float)$nota2 : 0;
                $n3 = is_numeric($nota3) && $nota3 > 0 ? (float)$nota3 : 0;
                $n4 = is_numeric($nota4) && $nota4 > 0 ? (float)$nota4 : 0;

                $seqError = false;
                if ($n4 > 0 && $n3 == 0) $seqError = true;
                if ($n3 > 0 && $n2 == 0) $seqError = true;
                if ($n2 > 0 && $n1 == 0) $seqError = true;
                
                if ($seqError) {
                    $errors[] = "Secuencia de periodos inválida para el estudiante $nombre. Las notas deben registrarse en orden (P1 -> P2 -> P3 -> P4).";
                    continue; // Skip saving this record
                }

                if ($n1 > 5 || $n2 > 5 || $n3 > 5 || $n4 > 5) {
                    $errors[] = "Las calificaciones no pueden ser mayores a 5.0 para el estudiante $nombre.";
                    continue;
                }
            }
            // ---------------------------------------

            $asignaturaObj = \App\Models\Asignatura::find($request->asignatura_id);
            $gradoAprobadoTxt = ($matriculaFinal->grado->nombre_grado ?? '') . ' - ' . ($matriculaFinal->grado->bloque ?? '');

            \App\Models\NotasDefinitivas::updateOrCreate(
                [
                    'id_matricula' => $matriculaFinal->id,
                    'asignatura_id' => $request->asignatura_id,
                ],
                [
                    'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                    'nombre_estudiante' => $estudiante->user->name,
                    'grado_aprobado' => $gradoAprobadoTxt,
                    'nota_per1' => $nota1,
                    'nota_per2' => $nota2,
                    'nota_per3' => $nota3,
                    'nota_per4' => $nota4,
                    'nota_definitiva' => $definitiva,
                    'nombre_asignatura' => $asignaturaObj->nombre_asignatura ?? 'Desconocida',
                    'curso' => $matriculaFinal->curso ?? '',
                    'observaciones' => $observaciones,
                ]
            );



            $savedCount++;
        }

        if (count($errors) > 0) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Atención',
                'text' => implode('\n', $errors)
            ])->withErrors($errors);
        }

        if ($savedCount === 0) {
            return back()->with('swal', [
                'icon' => 'info',
                'title' => 'Sin cambios',
                'text' => 'No se ingresaron notas para guardar.'
            ]);
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Las calificaciones han sido actualizadas.'
        ]);
    }

    public function promoverEstudiantes(Request $request)
    {
        $request->validate([
            'estudiantes_promovidos' => 'nullable|array',
            'estudiantes_reprobados' => 'nullable|array',
            'grado_destino_id' => 'required|exists:grado_academicos,id',
            'grado_origen_id' => 'required|exists:grado_academicos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'ano_lectivo' => 'required',
        ]);

        $user = auth()->user();
        $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
        $isDirectorOfThisGrade = GradoAcademico::where('id', $request->grado_origen_id)
            ->where('docente_id', $user->docente->id ?? null)
            ->exists();
        
        $isAssignedTeacher = \DB::table('asignatura_grado_docente')
            ->where('grado_academico_id', $request->grado_origen_id)
            ->where('asignatura_id', $request->asignatura_id)
            ->where('docente_id', $user->id)
            ->exists();

        if (!$isSuperAdmin && (!$isDirectorOfThisGrade && !$isAssignedTeacher)) {
            abort(403, 'No tiene permisos para realizar promociones en este grado/asignatura.');
        }

        $promovidos = $request->estudiantes_promovidos ?? [];
        $reprobados = $request->estudiantes_reprobados ?? [];
        $todos = array_merge($promovidos, $reprobados);

        if (empty($todos)) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin selección',
                'text' => 'No se han seleccionado estudiantes procesar.'
            ]);
        }

        $anoDestinoNum = intval($request->ano_lectivo) + 1;
        $nombreAnoDestino = strval($anoDestinoNum);

        $anoDestinoObj = AnhoEscolar::firstOrCreate(
            ['nombre_anho_escolar' => $nombreAnoDestino],
            ['estado_anho_escolar' => 0]
        );

        $errors = [];
        $processedCount = 0;
        $asignatura = Asignatura::findOrFail($request->asignatura_id);

        foreach ($todos as $estudianteId) {
            $isPromoted = in_array($estudianteId, $promovidos);
            $targetGradoId = $isPromoted ? $request->grado_destino_id : $request->grado_origen_id;
            $gradoDestinoObj = GradoAcademico::find($targetGradoId);

            $estudiante = Estudiante::with('user')->findOrFail($estudianteId);

            // Validar si fue promovido pero nota < 3 (Solo log/warning, no bloqueamos x confirmación de JS)
            $currentMatriculaFinal = \App\Models\MatriculaFinal::where([
                'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                'id_grado'             => $request->grado_origen_id,
            ])->orderBy('id', 'desc')->first();

            $notaDefinitiva = \App\Models\NotasDefinitivas::where('id_matricula', $currentMatriculaFinal?->id)
                ->where('asignatura_id', $request->asignatura_id)
                ->first();

            if ($isPromoted && (!$notaDefinitiva || $notaDefinitiva->nota_definitiva < 3)) {
                $defVal = $notaDefinitiva ? $notaDefinitiva->nota_definitiva : 'N/A';
                $errors[] = "{$estudiante->user->name} fue promovido a pesar de nota baja ($defVal).";
            }

            // Actualizar grado academico principal del estudiante
            $estudiante->update([
                'grado_academico_id' => $targetGradoId
            ]);

            // Crear matrícula oficial para el nuevo año y nuevo grado
            \App\Models\MatriculaFinal::updateOrCreate(
                [
                    'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                    'id_grado'             => $targetGradoId,
                    'ano_lectivo'          => $nombreAnoDestino,
                ],
                [
                    'id_sede'              => $gradoDestinoObj->sede_id ?? 1,
                    'curso'                => $gradoDestinoObj->curso->nombre_curso ?? $gradoDestinoObj->bloque ?? '1',
                    'fecha'                => now(),
                    'estado'               => 'activo',
                    'id_profesor'          => $gradoDestinoObj->docente_id ?? auth()->id(),
                    'documento_acudiente'  => $estudiante->acudiente->numero_identificacion_acudiente ?? null,
                    'parentezco_acudiente' => $estudiante->acudiente->parentezco ?? 'Padre/Madre',
                ]
            );

            $processedCount++;
        }

        $numPromovidos = count($promovidos);
        $numReprobados = count($reprobados);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Procesamiento Exitoso!',
            'text' => implode('\n', array_merge(["Se generaron matrículas para el año $nombreAnoDestino:", "- $numPromovidos Promovidos", "- $numReprobados No Promovidos"], $errors))
        ]);
    }

    public function asignatura_grado_docente()
    {
        $docente = auth()->user();

        $asignaturas = $docente->asignaturas;
        $grados = auth()->user()->docente?->grados;
        //dd($grado, $asignaturas);
        return view('Docente.grado.grado_docente', compact('asignaturas', 'grados'));
    }


    public function listadoClases($gradoId)
    {
        $grado = GradoAcademico::with('asignaturas')
                ->findOrFail($gradoId);

    $estudiantes = Matriculado::with('estudiante.user')
        ->where('grado_id', $gradoId)
        ->get();

    return view('Docente.grado.listado_clases', compact('grado', 'estudiantes'));
    }

    public function listaCalificarEstudiante()
    {
        
        $docente = auth()->user();

        $asignaturas = $docente->asignaturas;
        $grados = auth()->user()->docente?->grados;
        //dd($asignaturas, $grados);
        return view('Docente.grado.lista_calificar', compact('asignaturas', 'grados'));
    }
    
    public function calificarEstudianteFinal($gradoId)
    {
        $grado = GradoAcademico::with('asignaturas')
                ->findOrFail($gradoId);

    $estudiantes = Matriculado::with('estudiante.user')
        ->where('grado_id', $gradoId)
        ->get();

    return view('Docente.grado.calificar', compact('grado', 'estudiantes'));
    }

    public function guardarNotas(Request $request)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id'      => 'required|exists:grado_academicos,id',
            'notas'         => 'required|array',
            'periodo_academico_id' => 'nullable|exists:periodo_academicos,id',
        ]);

        $anhoEscolarId = AnhoEscolar::where('estado_anho_escolar', 1)
            ->orderBy('nombre_anho_escolar', 'desc')
            ->first()?->id ?? 1;

        foreach ($request->notas as $estudianteId => $data) {
            $notaValue = $data['nota'] ?? null;
            $observaciones = $data['observaciones'] ?? null;

            if ($notaValue === null) continue;

            // Buscamos si ya existe una nota para este estudiante/asignatura/grado
            // para no sobreescribir los periodos incorrectamente si la vista solo manda uno.
            // Si la vista es la simplificada de 1 periodo, la guardamos en 'nota' (legacy) 
            // y tratamos de mapearla a nota1 si es posible, o mantenemos la lógica actual.
            
            // Según el requerimiento, usemos la tabla notas con el formato mejorado.
            $estudiante = Estudiante::findOrFail($estudianteId);
            $matricula = Matriculado::firstOrCreate(
                [
                    'estudiante_id'   => $estudianteId,
                    'grado_id'        => $request->grado_id,
                    'asignatura_id'   => $request->asignatura_id,
                    'anho_escolar_id' => $anhoEscolarId,
                ],
                [
                    'acudiente_id'    => $estudiante->acudiente_id ?? 1,
                    'fecha_matricula' => now(),
                    'estado'          => 'activo'
                ]
            );

            $notaExistente = Notas::where('matriculado_id', $matricula->id)
                ->where('asignatura_id', $request->asignatura_id)
                ->first();

            $updateData = [
                'periodo_academico_id' => $request->periodo_academico_id ?? ($notaExistente->periodo_academico_id ?? 1),
                'grado_id'             => $request->grado_id,
                'estudiante_id'        => $estudianteId,
                'nota'                 => $notaValue,
                'observaciones'        => $observaciones,
            ];

            // Si es una vista de calificación rápida, asumimos que es para el periodo actual 
            // o simplemente guardamos la nota general.
            if (!$notaExistente || ($notaExistente->nota1 == 0)) {
                $updateData['nota1'] = $notaValue;
            }

            // Recalcular definitiva si ya existen otras notas
            $n1 = $updateData['nota1'] ?? ($notaExistente->nota1 ?? 0);
            $n2 = $notaExistente->nota2 ?? 0;
            $n3 = $notaExistente->nota3 ?? 0;
            $n4 = $notaExistente->nota4 ?? 0;

            $rawNotes = [$n1, $n2, $n3, $n4];
            $validNotes = array_filter($rawNotes, fn($n) => is_numeric($n) && (float)$n > 0);
            
            $updateData['nota_definitiva'] = count($validNotes) >= 3 
                ? array_sum($validNotes) / count($validNotes) 
                : 0; // Solo promediar si hay 3 o más notas válidas

            $newNota = Notas::updateOrCreate(
                [
                    'matriculado_id' => $matricula->id,
                    'asignatura_id' => $request->asignatura_id,
                ],
                $updateData
            );

            // Sincronización en tiempo real con NotasDefinitivas (Histórico/Certificados)
            $this->syncToNotasDefinitivas($newNota);
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Las calificaciones han sido guardadas correctamente.'
        ]);
    }

    private function syncToNotasDefinitivas(Notas $nota)
    {
        $nota->load(['matriculado.anhoEscolar', 'asignatura', 'estudiante.user', 'grado']);
        
        $anoLectivo = $nota->matriculado->anhoEscolar->nombre_anho_escolar ?? date('Y');
        
        // Buscar la matrícula final para vincular
        $matriculaFinal = \App\Models\MatriculaFinal::where([
            'documento_estudiante' => $nota->estudiante->numero_identificacion_estudiante,
            'ano_lectivo'          => $anoLectivo,
        ])->first();

        \App\Models\NotasDefinitivas::updateOrCreate(
            [
                'documento_estudiante' => $nota->estudiante->numero_identificacion_estudiante,
                'asignatura_id'        => $nota->asignatura_id,
                'grado_aprobado'       => ($nota->grado->nombre_grado ?? 'N/A') . ' - ' . ($nota->grado->bloque ?? ''),
            ],
            [
                'id_matricula'      => $matriculaFinal?->id,
                'nombre_estudiante' => $nota->estudiante->user->name ?? 'N/A',
                'nombre_asignatura' => $nota->asignatura->nombre_asignatura ?? 'N/A',
                'nota_per1'         => $nota->nota1 ?? 0,
                'nota_per2'         => $nota->nota2 ?? 0,
                'nota_per3'         => $nota->nota3 ?? 0,
                'nota_per4'         => $nota->nota4 ?? 0,
                'nota_definitiva'   => $nota->nota_definitiva,
                'curso'             => $nota->grado->bloque ?? '1',
            ]
        );
    }
}

