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
    public function index()
    {
        $docentes = Docente::with('user')->orderBy('id')->get();
        return view('Docente.Index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('Docente.Create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        // No necesitamos lista de usuarios, ya editamos el propio
        return view('Docente.Edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
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
        $isSuperAdmin = $user->roles()->whereIn('nombre', ['SUPERADMIN', 'ADMIN'])->exists();
        
        if ($isSuperAdmin) {
            // SuperAdmin/Admin ve todas las asignaciones de todos los docentes
            $gradosConMaterias = GradoAcademico::with(['asignaturas' => function($q) {
                $q->with(['hilo', 'docentes']);
            }])->get();
        } else {
            // El docente solo ve sus propias materias
            $gradosConMaterias = GradoAcademico::whereHas('asignaturas', function($q) use ($user) {
                $q->where('asignatura_grado_docente.docente_id', $user->id);
            })->with(['asignaturas' => function($q) use ($user) {
                $q->where('asignatura_grado_docente.docente_id', $user->id)->with('hilo');
            }])->get();
        }

        // Aplanamos para la vista
        $assignments = collect();
        foreach ($gradosConMaterias as $grado) {
            foreach ($grado->asignaturas as $asig) {
                // Para SuperAdmin, buscamos quién es el docente de esta materia en este grado
                $docenteNombre = 'N/A';
                if ($isSuperAdmin) {
                    // Obtenemos el docente desde la tabla pivote manualmente o via relación corregida
                    $pivot = \DB::table('asignatura_grado_docente')
                        ->where('grado_academico_id', $grado->id)
                        ->where('asignatura_id', $asig->id)
                        ->first();
                    
                    if ($pivot && $pivot->docente_id) {
                        $u = \App\Models\User::find($pivot->docente_id);
                        $docenteNombre = $u ? $u->name : 'N/A';
                    }
                }

                $assignments->push((object)[
                    'id'                => $asig->id,
                    'nombre_asignatura' => $asig->nombre_asignatura,
                    'hilo_nombre'       => $asig->hilo->nombre_hilo ?? 'N/A',
                    'grado_id'          => $grado->id,
                    'grado_nombre'      => $grado->nombre_grado . ' - ' . $grado->bloque,
                    'docente_nombre'    => $isSuperAdmin ? $docenteNombre : null,
                ]);
            }
        }

        return view('Docente.asignatura.asignatura_docente', compact('assignments', 'isSuperAdmin'));
    }

    public function estudiantesAsignatura($asignaturaId, $gradoId)
    {
        $asignatura = Asignatura::with(['hilo'])->findOrFail($asignaturaId);
        $grado = GradoAcademico::findOrFail($gradoId);
        
        $currentAnhoObj = AnhoEscolar::where('estado_anho_escolar', 1)->first();
        $anoLectivo = request('ano_lectivo') ?: ($currentAnhoObj?->nombre_anho_escolar ?? date('Y'));
        
        $esAnoActual = $currentAnhoObj && ($currentAnhoObj->nombre_anho_escolar == $anoLectivo);

        // Obtener documentos de estudiantes desde MatriculaFinal
        $documentos = \App\Models\MatriculaFinal::where('id_grado', $gradoId)
            ->where('ano_lectivo', $anoLectivo)
            ->pluck('documento_estudiante');

        $estudiantes = Estudiante::with(['user', 'notas' => function($query) use ($asignaturaId, $gradoId) {
            $query->where('asignatura_id', $asignaturaId)->where('grado_id', $gradoId);
        }])
        ->whereIn('numero_identificacion_estudiante', $documentos)
        ->get();

        // Si es histórico, intentar mapear desde NotasDefinitivas para mayor precisión
        if (!$esAnoActual) {
            $notasDefinitivas = \App\Models\NotasDefinitivas::where('asignatura_id', $asignaturaId)
                ->whereIn('documento_estudiante', $documentos)
                ->where('grado_aprobado', 'like', "%{$grado->nombre_grado}%")
                ->get();
            
            foreach ($estudiantes as $est) {
                $nd = $notasDefinitivas->where('documento_estudiante', $est->numero_identificacion_estudiante)->first();
                if ($nd) {
                    // Crear un objeto que imite el modelo Notas para que la vista funcione
                    $mockNota = (object)[
                        'nota1' => $nd->nota_per1,
                        'nota2' => $nd->nota_per2,
                        'nota3' => $nd->nota_per3,
                        'nota4' => $nd->nota_per4,
                        'nota_definitiva' => $nd->nota_definitiva,
                        'observaciones' => 'Registro Histórico (' . $anoLectivo . ')'
                    ];
                    $est->setRelation('notas', collect([$mockNota]));
                }
            }
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

        return view('Docente.asignatura.estudiantes_asignatura', compact(
            'asignatura', 
            'grado', 
            'estudiantes', 
            'todosLosGrados', 
            'all_graded',
            'esAnoActual',
            'anoLectivo'
        ));
    }

    public function updateNotas(Request $request)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id'      => 'required|exists:grado_academicos,id',
            'notas'         => 'required|array',
        ]);

        $anhoEscolarId = AnhoEscolar::where('estado_anho_escolar', 1)
            ->orderBy('nombre_anho_escolar', 'desc')
            ->first()?->id ?? 1; // Fallback to 1 if none active

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

            if (empty($observaciones)) {
                $estudiante = Estudiante::find($estudianteId);
                $nombre = $estudiante ? $estudiante->user->name : "ID: $estudianteId";
                $errors[] = "Las observaciones son obligatorias para el estudiante $nombre.";
                continue;
            }

            $estudiante = Estudiante::findOrFail($estudianteId);
            
            // Auto-matriculación si no existe para esta asignatura y año
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

            // Calcular definitiva: solo si hay más de 2 periodos con nota > 0
            // Filtrar solo notas válidas (> 0). Si P4 es 0 o vacío, no se cuenta.
            $rawNotes = [$nota1, $nota2, $nota3, $nota4];
            $validNotes = array_filter($rawNotes, fn($n) => is_numeric($n) && (float)$n > 0);
            
            $definitiva = count($validNotes) >= 3 
                ? array_sum($validNotes) / count($validNotes) 
                : 0; 

            $newNota = Notas::updateOrCreate(
                [
                    'matriculado_id' => $matricula->id,
                    'asignatura_id' => $request->asignatura_id,
                ],
                [
                    'estudiante_id' => $estudianteId,
                    'grado_id' => $request->grado_id,
                    'nota1' => $nota1,
                    'nota2' => $nota2,
                    'nota3' => $nota3,
                    'nota4' => $nota4,
                    'nota_definitiva' => $definitiva,
                    'observaciones' => $observaciones,
                ]
            );

            // Sincronización en tiempo real con NotasDefinitivas (Histórico/Certificados)
            $this->syncToNotasDefinitivas($newNota);

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
            'estudiantes' => 'required|array',
            'grado_destino_id' => 'required|exists:grado_academicos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);

        $errors = [];
        $promotedCount = 0;
        $gradoDestino = GradoAcademico::findOrFail($request->grado_destino_id);
        $asignatura = Asignatura::findOrFail($request->asignatura_id);

        foreach ($request->estudiantes as $estudianteId) {
            $estudiante = Estudiante::with('user')->findOrFail($estudianteId);
            
            // Grado actual del estudiante (del cual se está promoviendo)
            $gradoActual = GradoAcademico::find($estudiante->grado_academico_id);

            // Buscar la nota de la asignatura actual
            $nota = Notas::where('estudiante_id', $estudianteId)
                ->where('asignatura_id', $request->asignatura_id)
                ->where('grado_id', $estudiante->grado_academico_id)
                ->first();

            if (!$nota || $nota->nota_definitiva < 3) {
                $defVal = $nota ? $nota->nota_definitiva : 'N/A';
                $errors[] = "{$estudiante->user->name} no cumple el requisito (Nota: $defVal).";
                continue;
            }

            // 0. Buscar la matrícula final actual para vincular las notas
            $currentMatriculaFinal = \App\Models\MatriculaFinal::where([
                'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                'id_grado'             => $request->grado_id,
            ])->orderBy('id', 'desc')->first();

            // 1. Almacenar en NotasDefinitivas (Histórico)
            \App\Models\NotasDefinitivas::updateOrCreate(
                [
                    'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                    'asignatura_id'        => $asignatura->id,
                    'grado_aprobado'       => ($gradoActual->nombre_grado ?? 'N/A') . ' - ' . ($gradoActual->bloque ?? ''),
                ],
                [
                    'id_matricula'      => $currentMatriculaFinal?->id,
                    'nombre_estudiante' => $estudiante->user->name,
                    'nombre_asignatura' => $asignatura->nombre_asignatura,
                    'nota_per1'         => $nota->nota1 ?? 0,
                    'nota_per2'         => $nota->nota2 ?? 0,
                    'nota_per3'         => $nota->nota3 ?? 0,
                    'nota_per4'         => $nota->nota4 ?? 0,
                    'nota_definitiva'   => $nota->nota_definitiva,
                    'curso'             => $gradoActual->bloque ?? '1',
                ]
            );

            // 2. Ascender al estudiante al grado destino
            $estudiante->update([
                'grado_academico_id' => $request->grado_destino_id
            ]);

            $anhoEscolarId = AnhoEscolar::where('estado_anho_escolar', 1)
                ->orderBy('nombre_anho_escolar', 'desc')
                ->first()?->id ?? 1;

            $nuevaMatricula = Matriculado::updateOrCreate(
                [
                    'estudiante_id'   => $estudianteId,
                    'grado_id'        => $request->grado_destino_id,
                    'anho_escolar_id' => $anhoEscolarId,
                ],
                [
                    'fecha_matricula' => now(),
                    'estado'          => 'activo',
                    'acudiente_id'    => $estudiante->acudiente_id ?? 1
                ]
            );

            // Sincronizar con MatriculaFinal (usando el método privado si estuviera en un Trait, 
            // pero como está en otro controlador lo hacemos manual o movemos el método. 
            // Por simplicidad en este paso, lo replicamos o movemos a un Service).
            // Replicamos la lógica aquí para este controlador:
            \App\Models\MatriculaFinal::updateOrCreate(
                [
                    'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                    'id_grado'             => $request->grado_destino_id,
                    'ano_lectivo'          => AnhoEscolar::find($anhoEscolarId)->nombre_anho_escolar ?? date('Y'),
                ],
                [
                    'id_sede'              => $gradoDestino->sede_id ?? 1,
                    'curso'                => $gradoDestino->bloque ?? '1',
                    'fecha'                => now(),
                    'estado'               => 'activo',
                    'id_profesor'          => $gradoDestino->docente_id ?? auth()->id(),
                    'documento_acudiente'  => $estudiante->acudiente->numero_identificacion_acudiente ?? null,
                    'parentezco_acudiente' => $estudiante->acudiente->parentezco ?? 'Padre/Madre',
                ]
            );

            $promotedCount++;
        }

        if (count($errors) > 0) {
            return back()->with('swal', [
                'icon' => $promotedCount > 0 ? 'warning' : 'error',
                'title' => $promotedCount > 0 ? 'Promoción Parcial' : 'Error',
                'text' => implode('\n', $errors)
            ]);
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => "Se han promovido $promotedCount estudiantes, se archivaron sus notas definitivas y se generaron sus nuevas matrículas."
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

