<?php

namespace App\Http\Controllers;

use App\Models\GradoAcademico;
use App\Models\Estudiante;
use App\Models\CriterioGradoCero;
use App\Models\CalificacionGradoCero;
use App\Models\ObservacionGradoCero;
use App\Models\PeriodoAcademico;
use App\Models\AnhoEscolar;
use App\Models\Asignatura;
use App\Models\Institucion;
use App\Models\Docente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CalificacionGradoCeroController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Query base para grados de transición
        $query = GradoAcademico::where(function($q) {
            $q->where('nombre_grado', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_grado', 'LIKE', '%CERO%');
        });

        // Si es DIRECTOR, filtrar solo los que tiene a cargo
        if ($user->hasRol('DIRECTOR')) {
            $docente = Docente::where('user_id', $user->id)->first();
            if ($docente) {
                $query->where('docente_id', $docente->id);
            } else {
                // Si es director pero no tiene perfil de docente, no ve nada
                $query->whereRaw('1 = 0');
            }
        } 
        // Si no es SUPERADMIN ni DIRECTOR, no debería ver nada
        elseif (!$user->hasRol('SUPERADMIN')) {
            return redirect()->route('home')->with('swal', [
                'icon' => 'error',
                'title' => 'Acceso Denegado',
                'text' => 'No tiene permisos para acceder a este módulo.'
            ]);
        }

        $grados = $query->with(['sede', 'curso'])->get();
        $periodos = PeriodoAcademico::where('estado', 1)->get();
        $anhos = AnhoEscolar::where('estado_anho_escolar', 1)->get();

        return view('GradoCero.Calificaciones.index', compact('grados', 'periodos', 'anhos'));
    }

    public function matrix(Request $request)
    {
        $request->validate([
            'grado_id' => 'required|exists:grado_academicos,id',
            'periodo_id' => 'required|exists:periodo_academicos,id',
            'anho_escolar_id' => 'required|exists:anho_escolar,id',
        ]);

        $user = auth()->user();
        $grado = GradoAcademico::with(['sede', 'curso', 'asignaturas'])->findOrFail($request->grado_id);

        // Validación de permisos para la matriz
        if ($user->hasRol('DIRECTOR')) {
            $docente = Docente::where('user_id', $user->id)->first();
            if (!$docente || $grado->docente_id != $docente->id) {
                abort(403, 'No tiene permiso para calificar este grado.');
            }
        } elseif (!$user->hasRol('SUPERADMIN')) {
            abort(403);
        }
        $periodo = PeriodoAcademico::findOrFail($request->periodo_id);
        $anho = AnhoEscolar::findOrFail($request->anho_escolar_id);

        $estudiantes = Estudiante::with('user')
            ->where('grado_academico_id', $grado->id)
            ->get()
            ->sortBy('user.name');

        // Obtenemos todos los criterios de todas las asignaturas relevantes para Grado Cero
        // (Dimensiones, Cero, Transición)
        $asignaturasCero = Asignatura::whereHas('hilo', function($q) {
            $q->where('nombre_hilo', 'LIKE', '%CERO%')
              ->orWhere('nombre_hilo', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_hilo', 'LIKE', '%DIMENSION%');
        })->orWhereHas('grados', function($q) {
            $q->where('nombre_grado', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_grado', 'LIKE', '%CERO%');
        })->pluck('id');

        $criterios = CriterioGradoCero::with('asignatura')
            ->whereIn('asignatura_id', $asignaturasCero)
            ->where('estado', 1)
            ->get()
            ->groupBy('asignatura.nombre_asignatura');

        // Calificaciones existentes
        $calificaciones = CalificacionGradoCero::where('grado_academico_id', $grado->id)
            ->where('periodo_id', $periodo->id)
            ->where('anho_escolar_id', $anho->id)
            ->get()
            ->groupBy('estudiante_id');
            
        // Observaciones existentes
        $observaciones = ObservacionGradoCero::where('grado_academico_id', $grado->id)
            ->where('periodo_id', $periodo->id)
            ->where('anho_escolar_id', $anho->id)
            ->get()
            ->pluck('observacion', 'estudiante_id');

        return view('GradoCero.Calificaciones.matrix', compact('grado', 'periodo', 'anho', 'estudiantes', 'criterios', 'calificaciones', 'observaciones'));
    }

    public function store(Request $request)
    {
        $grado_id = $request->grado_id;
        $periodo_id = $request->periodo_id;
        $anho_id = $request->anho_escolar_id;

        // Caso 1: Se está calificando un criterio único para muchos estudiantes
        if ($request->has('criterio_id')) {
            $criterio_id = $request->criterio_id;
            if ($request->has('calificaciones')) {
                foreach ($request->calificaciones as $estudiante_id => $valor) {
                    if ($valor) {
                        CalificacionGradoCero::updateOrCreate([
                            'estudiante_id' => $estudiante_id,
                            'criterio_id' => $criterio_id,
                            'grado_academico_id' => $grado_id,
                            'periodo_id' => $periodo_id,
                            'anho_escolar_id' => $anho_id,
                        ], [
                            'valor' => $valor
                        ]);
                    }
                }
            }
        } 
        // Caso 2: Se está calificando la matriz completa (antiguo comportamiento, por si acaso)
        else if ($request->has('calificaciones')) {
            foreach ($request->calificaciones as $estudiante_id => $criterios) {
                foreach ($criterios as $criterio_id => $valor) {
                    if ($valor) {
                        CalificacionGradoCero::updateOrCreate([
                            'estudiante_id' => $estudiante_id,
                            'criterio_id' => $criterio_id,
                            'grado_academico_id' => $grado_id,
                            'periodo_id' => $periodo_id,
                            'anho_escolar_id' => $anho_id,
                        ], [
                            'valor' => $valor
                        ]);
                    }
                }
            }
        }

        // Guardar Observaciones (en ambos casos)
        if ($request->has('observaciones')) {
            foreach ($request->observaciones as $estudiante_id => $texto) {
                if ($texto) {
                    ObservacionGradoCero::updateOrCreate([
                        'estudiante_id' => $estudiante_id,
                        'grado_academico_id' => $grado_id,
                        'periodo_id' => $periodo_id,
                        'anho_escolar_id' => $anho_id,
                    ], [
                        'observacion' => $texto
                    ]);
                }
            }
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Guardado!',
            'text' => 'Las calificaciones y observaciones han sido guardadas.'
        ]);
    }

    public function descargarBoletin($estudiante_id, $periodo_id, $anho_id)
    {
        $estudiante = Estudiante::with(['user', 'gradoAcademico.sede', 'gradoAcademico.curso'])->findOrFail($estudiante_id);
        $periodo = PeriodoAcademico::findOrFail($periodo_id);
        $anho = AnhoEscolar::findOrFail($anho_id);
        $institucion = Institucion::first();

        $grado = $estudiante->gradoAcademico;
        
        // Criterios agrupados por asignatura (Matriz Completa de Grado Cero)
        $asignaturasCero = Asignatura::whereHas('hilo', function($q) {
            $q->where('nombre_hilo', 'LIKE', '%CERO%')
              ->orWhere('nombre_hilo', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_hilo', 'LIKE', '%DIMENSION%');
        })->orWhereHas('grados', function($q) {
            $q->where('nombre_grado', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_grado', 'LIKE', '%CERO%');
        })->pluck('id');

        $criterios = CriterioGradoCero::with('asignatura')
            ->whereIn('asignatura_id', $asignaturasCero)
            ->where('estado', 1)
            ->get()
            ->groupBy('asignatura.nombre_asignatura');

        $calificaciones = CalificacionGradoCero::where('estudiante_id', $estudiante_id)
            ->where('periodo_id', $periodo_id)
            ->where('anho_escolar_id', $anho_id)
            ->get()
            ->pluck('valor', 'criterio_id');

        $observacion = ObservacionGradoCero::where('estudiante_id', $estudiante_id)
            ->where('periodo_id', $periodo_id)
            ->where('anho_escolar_id', $anho_id)
            ->first();

        $pdf = Pdf::loadView('GradoCero.Boletin.pdf', compact('estudiante', 'periodo', 'anho', 'institucion', 'criterios', 'calificaciones', 'observacion'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream("Boletin_{$estudiante->user->name}_{$periodo->nombre_periodo}.pdf");
    }

    public function descargarGrupo($grado_id, $periodo_id, $anho_id)
    {
        $grado = GradoAcademico::with(['sede', 'curso', 'docente.user'])->findOrFail($grado_id);
        $periodo = PeriodoAcademico::findOrFail($periodo_id);
        $anho = AnhoEscolar::findOrFail($anho_id);
        $institucion = Institucion::first();

        $estudiantes = Estudiante::with('user')
            ->where('grado_academico_id', $grado->id)
            ->get();

        $asignaturasIds = $grado->asignaturas->pluck('id');
        $criterios = CriterioGradoCero::with('asignatura')
            ->whereIn('asignatura_id', $asignaturasIds)
            ->where('estado', 1)
            ->get()
            ->groupBy('asignatura.nombre_asignatura');

        $bulkData = [];
        foreach ($estudiantes as $estudiante) {
            $calificaciones = CalificacionGradoCero::where('estudiante_id', $estudiante->id)
                ->where('periodo_id', $periodo_id)
                ->where('anho_escolar_id', $anho_id)
                ->get()
                ->pluck('valor', 'criterio_id');

            $observacion = ObservacionGradoCero::where('estudiante_id', $estudiante->id)
                ->where('periodo_id', $periodo_id)
                ->where('anho_escolar_id', $anho_id)
                ->first();

            $bulkData[] = [
                'estudiante' => $estudiante,
                'calificaciones' => $calificaciones,
                'observacion' => $observacion
            ];
        }

        $pdf = Pdf::loadView('GradoCero.Boletin.pdf_grupo', compact('grado', 'periodo', 'anho', 'institucion', 'criterios', 'bulkData'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream("Boletines_Grupo_{$grado->nombre_grado}_{$periodo->nombre_periodo}.pdf");
    }

    public function promocion(GradoAcademico $grado)
    {
        $user = auth()->user();
        if ($user->hasRol('DIRECTOR')) {
            $docente = Docente::where('user_id', $user->id)->first();
            if (!$docente || $grado->docente_id != $docente->id) {
                abort(403);
            }
        } elseif (!$user->hasRol('SUPERADMIN')) {
            abort(403);
        }

        $estudiantes = Estudiante::with('user')
            ->where('grado_academico_id', $grado->id)
            ->get()
            ->sortBy('user.name');

        $gradosDestino = GradoAcademico::with(['sede', 'curso'])->get();
        $anhosDestino = AnhoEscolar::all();
        
        return view('GradoCero.Calificaciones.promocion', compact('grado', 'estudiantes', 'gradosDestino', 'anhosDestino'));
    }

    public function procesarPromocion(Request $request)
    {
        $request->validate([
            'estudiantes' => 'required|array|min:1',
            'grado_destino_id' => 'required|exists:grado_academicos,id',
            'anho_destino_id' => 'required|exists:anho_escolar,id',
        ]);

        $gradoDestino = GradoAcademico::findOrFail($request->grado_destino_id);
        $anhoDestino = AnhoEscolar::findOrFail($request->anho_destino_id);

        \DB::transaction(function() use ($request, $gradoDestino, $anhoDestino) {
            foreach ($request->estudiantes as $estudianteId) {
                $estudiante = Estudiante::findOrFail($estudianteId);
                
                // 1. Actualizar el grado en el perfil del estudiante
                $estudiante->update([
                    'grado_academico_id' => $gradoDestino->id
                ]);

                // 2. Crear registro de matriculado para el nuevo ciclo
                Matriculado::updateOrCreate([
                    'estudiante_id' => $estudiante->id,
                    'grado_id' => $gradoDestino->id,
                    'anho_escolar_id' => $anhoDestino->id,
                ], [
                    'acudiente_id' => $estudiante->acudiente_id ?? 1,
                    'fecha_matricula' => now(),
                    'estado' => 'activo'
                ]);

                // 3. Sincronizar con MatriculaFinal
                \App\Models\MatriculaFinal::updateOrCreate([
                    'documento_estudiante' => $estudiante->numero_identificacion_estudiante,
                    'id_grado' => $gradoDestino->id,
                    'ano_lectivo' => $anhoDestino->nombre_anho_escolar,
                ], [
                    'id_sede' => $gradoDestino->sede_id,
                    'curso' => $gradoDestino->curso->nombre_curso ?? $gradoDestino->bloque,
                    'fecha' => now(),
                    'estado' => 'activo',
                    'id_profesor' => $gradoDestino->docente_id ?? auth()->id(),
                ]);
            }
        });

        return redirect()->route('admin.grado-cero.calificaciones.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Promoción Exitosa!',
            'text' => 'Los estudiantes seleccionados han sido promovidos.'
        ]);
    }
}
