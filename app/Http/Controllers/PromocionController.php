<?php

namespace App\Http\Controllers;

use App\Models\GradoAcademico;
use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\NotasDefinitivas;
use App\Models\MatriculaFinal;
use App\Models\AnhoEscolar;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromocionController extends Controller
{
    /**
     * Listado de grados para promoción.
     */
    public function index()
    {
        $user = auth()->user();
        $query = GradoAcademico::with(['sede', 'curso']);

        // Roles Administrativos: Ven todos
        if ($user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN')) {
            // No filter
        } 
        // Director de Grado: Solo ve el suyo
        elseif ($user->hasRol('DIRECTOR')) {
            $docente = Docente::where('user_id', $user->id)->first();
            if ($docente) {
                $query->where('docente_id', $docente->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        } else {
            abort(403, 'No tiene permisos para acceder a este módulo.');
        }

        $grados = $query->get();
        return view('promocion.index', compact('grados'));
    }

    /**
     * Muestra la planilla de promoción de un grado específico.
     */
    public function show($id)
    {
        $user = auth()->user();
        $grado = GradoAcademico::with(['sede', 'curso'])->findOrFail($id);

        // Permisos
        if (!$user->hasRol('SUPERADMIN') && !$user->hasRol('ADMIN')) {
            $docente = Docente::where('user_id', $user->id)->first();
            if (!$docente || $grado->docente_id != $docente->id) {
                abort(403, 'No tiene permiso para ver este grado.');
            }
        }

        $estudiantes = Estudiante::with('user')
            ->where('grado_academico_id', $grado->id)
            ->get()
            ->sortBy('user.name');

        // Asignaturas vinculadas al grado
        $asignaturas = $grado->asignaturas;

        // Año lectivo actual (el más reciente activo)
        $anhoActual = AnhoEscolar::where('estado_anho_escolar', 1)
            ->orderBy('nombre_anho_escolar', 'desc')
            ->first();
        
        $anoLectivo = $anhoActual ? $anhoActual->nombre_anho_escolar : date('Y');

        // Obtener todas las notas definitivas de estos estudiantes en este grado
        // Usamos los documentos de identidad para cruzar datos
        $documentos = $estudiantes->pluck('numero_identificacion_estudiante');
        
        $notasDefinitivas = NotasDefinitivas::whereIn('documento_estudiante', $documentos)
            ->where('grado_aprobado', 'LIKE', '%' . $grado->nombre_grado . '%')
            ->get();

        // Mapear notas por estudiante y asignatura
        $matrix = [];
        foreach ($estudiantes as $est) {
            $est_notas = [];
            $perdidas = 0;
            foreach ($asignaturas as $asig) {
                // Buscamos la nota. Intentamos por id_matricula si es el año actual, o por texto
                $nota = $notasDefinitivas->where('documento_estudiante', $est->numero_identificacion_estudiante)
                    ->where('asignatura_id', $asig->id)
                    ->first();
                
                $valor = $nota ? $nota->nota_definitiva : null;
                $est_notas[$asig->id] = $valor;
                
                if ($valor !== null && $valor < 3.0) {
                    $perdidas++;
                }
            }
            $matrix[$est->id] = [
                'notas' => $est_notas,
                'perdidas' => $perdidas
            ];
        }

        $todosLosGrados = GradoAcademico::orderBy('nombre_grado')->get();
        $anhosEscolares = AnhoEscolar::orderBy('nombre_anho_escolar', 'desc')->get();

        return view('promocion.show', compact('grado', 'estudiantes', 'asignaturas', 'matrix', 'todosLosGrados', 'anhosEscolares', 'anoLectivo'));
    }

    /**
     * Procesa la promoción masiva.
     */
    public function promover(Request $request)
    {
        $request->validate([
            'grado_origen_id' => 'required|exists:grado_academicos,id',
            'estudiantes_promovidos' => 'nullable|array',
            'estudiantes_reprobados' => 'nullable|array',
            'grado_destino_id' => 'nullable|exists:grado_academicos,id',
            'ano_lectivo_destino' => 'required',
        ]);

        $gradoOrigen = GradoAcademico::findOrFail($request->grado_origen_id);
        $user = auth()->user();
        
        // Strict Permission Check
        $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
        $isGradeDirector = Docente::where('user_id', $user->id)->where('id', $gradoOrigen->docente_id)->exists();

        if (!$isSuperAdmin && !$isGradeDirector) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Acceso Denegado',
                'text' => 'Solo el Director de curso o el Administrador pueden procesar la promoción.'
            ]);
        }

        $promovidos = $request->estudiantes_promovidos ?? [];
        $reprobados = $request->estudiantes_reprobados ?? [];
        
        $nombreGrado = strtoupper($gradoOrigen->nombre_grado);
        $esOnce = (str_contains($nombreGrado, 'ONCE') || str_contains($nombreGrado, 'UNDECIMO'));

        $countPromovidos = 0;
        $countReprobados = 0;
        $errors = [];

        // Asegurar que el año destino existe
        $anhoDestino = AnhoEscolar::firstOrCreate(
            ['nombre_anho_escolar' => $request->ano_lectivo_destino],
            ['estado_anho_escolar' => 0]
        );

        DB::beginTransaction();
        try {
            // PROMOVIDOS
            foreach ($promovidos as $id) {
                $estudiante = Estudiante::findOrFail($id);
                
                if ($esOnce) {
                    // Grado Once NO se promueve a un grado superior (no hay 12)
                    // Simplemente se podría marcar como "Graduado" o terminar su ciclo.
                    // Aquí solo incrementamos contador por ahora.
                    $countPromovidos++;
                } else {
                    if (!$request->grado_destino_id) {
                        throw new \Exception("Debe seleccionar un grado destino para los estudiantes promovidos.");
                    }
                    
                    $gradoDestino = GradoAcademico::find($request->grado_destino_id);

                    // Actualizar grado de estudiante
                    $estudiante->update(['grado_academico_id' => $request->grado_destino_id]);

                    // Crear matrícula nueva
                    MatriculaFinal::updateOrCreate(
                        [
                            'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                            'id_grado' => $request->grado_destino_id,
                            'ano_lectivo' => $anhoDestino->nombre_anho_escolar
                        ],
                        [
                            'id_sede' => $gradoDestino->sede_id ?? 1,
                            'curso' => $gradoDestino->curso->nombre_curso ?? $gradoDestino->bloque ?? '1',
                            'fecha' => now(),
                            'estado' => 'activo',
                            'id_profesor' => $gradoDestino->docente_id ?? auth()->id(),
                            'documento_acudiente' => $estudiante->acudiente->numero_identificacion_acudiente ?? null,
                            'parentezco_acudiente' => $estudiante->acudiente->parentezco ?? 'Padre/Madre',
                        ]
                    );
                    $countPromovidos++;
                }
            }

            // REPROBADOS
            foreach ($reprobados as $id) {
                $estudiante = Estudiante::findOrFail($id);
                
                // Reprobados permanecen en el mismo grado (grado_origen_id) pero en el nuevo año
                MatriculaFinal::updateOrCreate(
                    [
                        'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                        'id_grado' => $gradoOrigen->id,
                        'ano_lectivo' => $anhoDestino->nombre_anho_escolar
                    ],
                    [
                        'id_sede' => $gradoOrigen->sede_id ?? 1,
                        'curso' => $gradoOrigen->curso->nombre_curso ?? $gradoOrigen->bloque ?? '1',
                        'fecha' => now(),
                        'estado' => 'activo',
                        'id_profesor' => $gradoOrigen->docente_id ?? auth()->id(),
                        'documento_acudiente' => $estudiante->acudiente->numero_identificacion_acudiente ?? null,
                        'parentezco_acudiente' => $estudiante->acudiente->parentezco ?? 'Padre/Madre',
                    ]
                );
                $countReprobados++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error en proceso',
                'text' => $e->getMessage()
            ]);
        }

        $text = "Proceso completado: $countPromovidos promovidos";
        if ($esOnce) $text .= " (Finalización ciclo)";
        $text .= " y $countReprobados reprobados (Repitentes en $request->ano_lectivo_destino).";

        return redirect()->route('admin.promocion.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => $text
        ]);
    }
}
