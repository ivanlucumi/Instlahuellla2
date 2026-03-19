<?php

namespace App\Http\Controllers;

use App\Models\GradoAcademico;
use Illuminate\Http\Request;

class GradoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allGrados = GradoAcademico::orderBy('nombre_grado')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $anhos = \App\Models\AnhoEscolar::orderBy('nombre_anho_escolar', 'desc')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();

        $query = GradoAcademico::with(['sede', 'docente.user', 'asignaturas', 'curso']);

        // Si es DIRECTOR y no SUPERADMIN/ADMIN, solo ve sus propios grados
        if (auth()->user()->hasRol('DIRECTOR') && !auth()->user()->hasRol('SUPERADMIN') && !auth()->user()->hasRol('ADMIN')) {
            $query->whereHas('docente', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        $enrollmentsResults = null;
        $searchSummary = '';
        $currentAnho = $anhos->where('estado_anho_escolar', 1)->first()?->nombre_anho_escolar;

        // Si hay filtros, buscamos en MatriculaFinal para obtener los IDs de grados coincidentes 
        if ($request->anyFilled(['grado_id', 'curso_id', 'anho_escolar_id', 'asignatura_id'])) {
            $mfQuery = \App\Models\MatriculaFinal::with(['grado', 'notasDefinitivas']);

            $summaryParts = [];

            if ($request->filled('grado_id')) {
                $mfQuery->where('id_grado', $request->grado_id);
                $gradoName = $allGrados->find($request->grado_id)->nombre_grado ?? '';
                $summaryParts[] = "Grado: $gradoName";
            }

            if ($request->filled('anho_escolar_id')) {
                $anho = $anhos->find($request->anho_escolar_id);
                if ($anho) {
                    $mfQuery->where('ano_lectivo', $anho->nombre_anho_escolar);
                    $summaryParts[] = "Año: {$anho->nombre_anho_escolar}";
                }
            }

            if ($request->filled('curso_id')) {
                $mfQuery->whereIn('id_grado', function($q) use ($request) {
                    $q->select('id')->from('grado_academicos')->where('curso_id', $request->curso_id);
                });
                $cursoName = $cursos->find($request->curso_id)->nombre_curso ?? '';
                $summaryParts[] = "Curso: $cursoName";
            }

            if ($request->filled('asignatura_id')) {
                $asigName = $asignaturas->find($request->asignatura_id)->nombre_asignatura ?? '';
                $summaryParts[] = "Asignatura: $asigName";
            }

            $searchSummary = implode(' | ', $summaryParts);

            $resultsMF = $mfQuery->get();
            $gradoIds = $resultsMF->pluck('id_grado')->unique();
            $query->whereIn('id', $gradoIds);

            // Cargamos los datos de los estudiantes para los resultados de matrícula
            if ($request->filled('grado_id') && $request->filled('anho_escolar_id')) {
                $enrollmentsResults = $resultsMF->map(function($mf) use ($request) {
                    $mf->estudiante = \App\Models\Estudiante::with('user')
                        ->where('numero_identificacion_estudiante', $mf->documento_estudiante)
                        ->first();
                    
                    $mf->notaResult = $mf->notasDefinitivas->when($request->filled('asignatura_id'), function($collection) use ($request) {
                        return $collection->where('asignatura_id', $request->asignatura_id);
                    })->first();

                    return $mf;
                });

                // REGLA: Si se filtró por asignatura, solo traer los que tengan nota
                if ($request->filled('asignatura_id')) {
                    $enrollmentsResults = $enrollmentsResults->filter(fn($e) => !empty($e->notaResult));
                }
            }
        }

        $perPage = $request->get('per_page', 15);
        $grados = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());
        
        return view('GradoAcademico.Index', compact('grados', 'cursos', 'anhos', 'allGrados', 'asignaturas', 'enrollmentsResults', 'searchSummary', 'currentAnho'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sedes = \App\Models\Sede::orderBy('nombre_sede')->get();
        $docentes = \App\Models\Docente::with('user')->get(); // For Director de Grado
        $users = \App\Models\User::whereHas('docente')->orderBy('name')->get(); // For Specialist Teachers
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();

        return view('GradoAcademico.Create', compact('sedes', 'docentes', 'users', 'asignaturas', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_grado'           => 'required|string|max:255',
            'bloque'                 => 'nullable|string|max:255',
            'sede_id'                => 'nullable|exists:sedes,id',
            'docente_id'             => 'nullable|exists:docentes,id',
            'curso_id'               => 'nullable|exists:cursos,id',
            'estado_grado_academico' => 'nullable|boolean',
            'asignaturas'            => 'nullable|array',
            'asignaturas.*.id'       => 'required|exists:asignaturas,id',
            'asignaturas.*.docente_id'=> 'nullable|exists:users,id',
        ]);

        // Check for duplicate subjects in the request
        if ($request->has('asignaturas')) {
            $subjectIds = array_column($request->asignaturas, 'id');
            if (count($subjectIds) !== count(array_unique($subjectIds))) {
                return back()->withErrors(['asignaturas' => 'No puedes asignar la misma asignatura más de una vez.'])->withInput();
            }
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $gradoAcademico = GradoAcademico::create([
                'nombre_grado'           => $request->nombre_grado,
                'bloque'                 => $request->bloque,
                'sede_id'                => $request->sede_id,
                'docente_id'             => $request->docente_id,
                'curso_id'               => $request->curso_id,
                'estado_grado_academico' => $request->has('estado_grado_academico') ? 1 : 0,
            ]);

            // Sync subjects with pivot data
            if ($request->has('asignaturas')) {
                $syncData = [];
                foreach ($request->asignaturas as $asig) {
                    if (isset($asig['id'])) {
                        $syncData[$asig['id']] = ['docente_id' => $asig['docente_id'] ?? null];
                    }
                }
                $gradoAcademico->asignaturas()->sync($syncData);
            }

            // Manage DIRECTOR role
            $this->syncDirectorRole($request->docente_id);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.gradoacademico.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El grado académico fue registrado correctamente.'
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Ocurrió un error al guardar el grado: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, GradoAcademico $gradoAcademico)
    {
        // Autorización: un director solo puede ver su propio grado
        if (auth()->user()->hasRol('DIRECTOR') && !auth()->user()->hasRol('SUPERADMIN') && !auth()->user()->hasRol('ADMIN')) {
            $esSuGrado = $gradoAcademico->docente && $gradoAcademico->docente->user_id === auth()->id();
            if (!$esSuGrado) {
                abort(403, 'No tienes permiso para ver este grado académico.');
            }
        }

        // 1. Contexto Académico
        $anhos = \App\Models\AnhoEscolar::orderBy('nombre_anho_escolar', 'desc')->get();
        $anhoId = $request->get('anho_escolar_id');
        $currentAnhoObj = $anhoId 
            ? $anhos->find($anhoId) 
            : $anhos->where('estado_anho_escolar', 1)->first() ?? $anhos->first();
        
        $anoLectivo = $currentAnhoObj->nombre_anho_escolar ?? date('Y');

        // Determinar si el año seleccionado es el año en curso
        $anhoActual = date('Y');
        $esAnhoActual = ((string)$anoLectivo === (string)$anhoActual);

        // 2. Otros cursos (bloques) del mismo nivel Y MISMA SEDE
        $cursosDisponibles = GradoAcademico::where('nombre_grado', $gradoAcademico->nombre_grado)
            ->where('sede_id', $gradoAcademico->sede_id)
            ->with('curso')
            ->get();



        // 3. Cargar relaciones base del grado
        $gradoAcademico->load([
            'sede', 
            'docente.user', 
            'asignaturas.hilo',
            'asignaturas.docentes',
        ]);

        // Preferimos el nombre_curso de la relación si existe, sino el bloque como fallback
        $cursoTarget = $gradoAcademico->curso->nombre_curso ?? $gradoAcademico->bloque;

        // 4. Estudiantes matriculados según Año Lectivo, CURSO ESPECÍFICO y SEDE
        // Filtramos estrictamente por id_grado, año, curso, sede y omitimos a los "Retirados"
        $matriculadosMF = \App\Models\MatriculaFinal::where('id_grado', $gradoAcademico->id)
            ->where('ano_lectivo', $anoLectivo)
            ->where('curso', (string)$cursoTarget)
            ->where('id_sede', $gradoAcademico->sede_id) // Filter by the grade's sede
            ->where('estado', '!=', 'Retirado')
            ->get();

           // DD($cursoTarget, $gradoAcademico->sede_id, $anoLectivo, $gradoAcademico);
        
        $documentosMatriculados = $matriculadosMF->pluck('documento_estudiante');

        // 5. Asignaturas: 
        //    - Año actual → desde la tabla pivot asignatura_grado_docente (ya cargada en ->asignaturas)
        //    - Otros años → desde notas_definitivas relacionadas a las matrículas de ese año
        if ($esAnhoActual) {
            // Asignaturas del pivot: ya están cargadas en $gradoAcademico->asignaturas
            // No sobreescribimos la relación.
        } else {
            // Asignaturas que aparecen en notas_definitivas para ese año
            $asignaturasActivasIds = \App\Models\NotasDefinitivas::whereIn('id_matricula', $matriculadosMF->pluck('id'))
                ->distinct()
                ->pluck('asignatura_id')
                ->toArray();

            $gradoAcademico->setRelation(
                'asignaturas',
                $gradoAcademico->asignaturas->whereIn('id', $asignaturasActivasIds)
            );
        }

        $estudiantes = \App\Models\Estudiante::whereIn('numero_identificacion_estudiante', $documentosMatriculados)
            ->with('user')
            ->get();

        // 6. Datos para Modales de Gestión
        $allAsignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $allUsers = \App\Models\User::whereHas('docente')->orderBy('name')->get();
        
        // Estudiantes disponibles para matricular (los que NO están en este grado/año)
        $estudiantesDisponibles = \App\Models\Estudiante::with('user')
            ->whereNotIn('numero_identificacion_estudiante', $documentosMatriculados)
            ->limit(100)
            ->get();

        return view('GradoAcademico.Show', compact(
            'gradoAcademico', 
            'estudiantes',
            'matriculadosMF',
            'anhos', 
            'currentAnhoObj',
            'esAnhoActual',
            'cursosDisponibles',
            'allAsignaturas',
            'allUsers',
            'estudiantesDisponibles'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradoAcademico $gradoAcademico)
    {
        $sedes = \App\Models\Sede::orderBy('nombre_sede')->get();
        $docentes = \App\Models\Docente::with('user')->get(); // For Director de Grado
        $users = \App\Models\User::whereHas('docente')->orderBy('name')->get(); // For Specialist Teachers
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        
        return view('GradoAcademico.Edit', compact('gradoAcademico', 'sedes', 'docentes', 'users', 'asignaturas', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradoAcademico $gradoAcademico)
    {
        $request->validate([
            'nombre_grado'           => 'required|string|max:255',
            'bloque'                 => 'nullable|string|max:255',
            'sede_id'                => 'nullable|exists:sedes,id',
            'docente_id'             => 'nullable|exists:docentes,id',
            'curso_id'               => 'nullable|exists:cursos,id',
            'estado_grado_academico' => 'nullable|boolean',
            'asignaturas'            => 'nullable|array',
            'asignaturas.*.id'       => 'required|exists:asignaturas,id',
            'asignaturas.*.docente_id'=> 'nullable|exists:users,id',
        ]);

         // Check for duplicate subjects in the request
         if ($request->has('asignaturas')) {
            $subjectIds = array_column($request->asignaturas, 'id');
            if (count($subjectIds) !== count(array_unique($subjectIds))) {
                return back()->withErrors(['asignaturas' => 'No puedes asignar la misma asignatura más de una vez.'])->withInput();
            }
        }

        try {
            $oldDocenteId = $gradoAcademico->docente_id;
            \Illuminate\Support\Facades\DB::beginTransaction();

            $gradoAcademico->update([
                'nombre_grado'           => $request->nombre_grado,
                'bloque'                 => $request->bloque,
                'sede_id'                => $request->sede_id,
                'docente_id'             => $request->docente_id,
                'curso_id'               => $request->curso_id,
                'estado_grado_academico' => $request->has('estado_grado_academico') ? 1 : 0,
            ]);

            // Sync subjects with pivot data
            if ($request->has('asignaturas')) {
                $syncData = [];
                foreach ($request->asignaturas as $asig) {
                    if (isset($asig['id'])) {
                        $syncData[$asig['id']] = ['docente_id' => $asig['docente_id'] ?? null];
                    }
                }
                $gradoAcademico->asignaturas()->sync($syncData);
            } else {
                $gradoAcademico->asignaturas()->sync([]);
            }

            // Manage DIRECTOR roles for old and new director
            if ($oldDocenteId != $request->docente_id) {
                $this->syncDirectorRole($oldDocenteId);
            }
            $this->syncDirectorRole($request->docente_id);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.gradoacademico.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Proceso exitoso!',
                'text'  => 'El grado académico fue actualizado correctamente.'
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Ocurrió un error al actualizar el grado: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradoAcademico $gradoAcademico)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $directorId = $gradoAcademico->docente_id;
        $gradoAcademico->delete();

        // Refresh role for the teacher who was the director
        $this->syncDirectorRole($directorId);

        return redirect()->route('admin.gradoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El grado académico fue eliminado correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
        $request->validate([
            'nombre_grado' => 'required|string|max:255',
            'bloque'       => 'required|string|max:255',
        ]);

        try {
            $sede = \App\Models\Sede::first();
            $docente = \App\Models\Docente::first();

            $grado = GradoAcademico::create([
                'nombre_grado'           => $request->nombre_grado,
                'bloque'                 => $request->bloque,
                'sede_id'                => $sede->id ?? 1,
                'docente_id'             => $docente->id ?? 1,
                'estado_grado_academico' => 1,
            ]);

            return response()->json([
                'id' => $grado->id,
                'text' => $grado->nombre_grado . ' - ' . $grado->bloque,
                'message' => 'Grado académico creado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el grado académico: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $grados = GradoAcademico::all()->map(function($g) {
            return [
                'id' => $g->id,
                'text' => $g->nombre_grado . ' - ' . $g->bloque
            ];
        });
        return response()->json($grados);
    }

    /**
     * Sincroniza el rol de DIRECTOR para un docente según sus grados asignados.
     */
    private function syncDirectorRole($docenteId)
    {
        if (!$docenteId) return;

        $docente = \App\Models\Docente::with('user')->find($docenteId);
        if (!$docente || !$docente->user) return;

        $directorRole = \App\Models\Rol::where('nombre', 'DIRECTOR')->first();
        if (!$directorRole) return;

        $isStillDirector = GradoAcademico::where('docente_id', $docenteId)->exists();

        if ($isStillDirector) {
            if (!$docente->user->hasRol('DIRECTOR')) {
                $docente->user->roles()->attach($directorRole->id);
            }
        } else {
            // Se quita el rol de DIRECTOR si ya no dirige ningún grado
            if ($docente->user->hasRol('DIRECTOR')) {
                $docente->user->roles()->detach($directorRole->id);
            }
        }
    }
}
