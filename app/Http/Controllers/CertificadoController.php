<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\AnhoEscolar;
use App\Models\PeriodoAcademico;
use App\Models\Notas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    /**
     * Muestra la interfaz para seleccionar el estudiante y el año escolar.
     */
    public function index(Request $request)
    {
        // Obtener estudiantes con su información de usuario para el buscador
        $estudiantes = Estudiante::with('user')->get()->map(function ($e) {
            return [
                'identificacion' => $e->numero_identificacion_estudiante,
                'nombre' => ($e->user->name ?? 'Sin nombre') . " (" . $e->numero_identificacion_estudiante . ")"
            ];
        })->sortBy('nombre');

        // Obtener los grados únicos presentes en notas_definitivas
        $grados = \App\Models\NotasDefinitivas::distinct()->pluck('grado_aprobado')->sort();

        return view('Certificado.Index', compact('estudiantes', 'grados'));
    }

    /**
     * Genera el PDF del certificado de notas.
     */
    public function generar(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string',
            'grado_aprobado' => 'required|string',
        ]);

        // 1. Buscar al estudiante
        $estudiante = Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])
            ->where('numero_identificacion_estudiante', $request->identificacion)
            ->first();

        if (!$estudiante) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'No encontrado',
                'text' => 'No se encontró ningún estudiante con el número de identificación proporcionado.'
            ]);
        }

        // 2. Buscar todas las matrículas para ese grado que NO estén en estado 'Retirado'
        // Esto maneja a los repitentes
        $matriculasOptions = \App\Models\MatriculaFinal::with(['grado.docente.user', 'sede', 'profesor'])
            ->where('documento_estudiante', $request->identificacion)
            ->where('estado', '!=', 'Retirado')
            ->whereHas('grado', function ($q) use ($request) {
                $q->where('nombre_grado', $request->grado_aprobado);
            })
            ->get();

        if ($matriculasOptions->isEmpty()) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin registros válidos',
                'text' => "El estudiante no cuenta con matrículas activas o aprobadas para el grado {$request->grado_aprobado} (Solo se certifican matrículas que no estén en estado Retirado)."
            ]);
        }

        // 3. Si hay más de una matrícula (repitente), mostramos listado para elegir
        if ($matriculasOptions->count() > 1 && !$request->has('matricula_id')) {
            return view('Certificado.Listado', [
                'estudiante' => $estudiante,
                'grado_nombre' => $request->grado_aprobado,
                'matriculas' => $matriculasOptions
            ]);
        }

        // 4. Seleccionar la matrícula a procesar
        $matricula = $request->has('matricula_id')
            ? $matriculasOptions->find($request->matricula_id)
            : $matriculasOptions->first();

        if (!$matricula) {
            return redirect()->route('admin.certificados.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'La matrícula seleccionada no es válida.'
            ]);
        }

        // 5. Buscar las notas definitivas para ESTA matrícula específica
        $notasDefinitivas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)
            ->get();

        // Fallback por si id_matricula no está vinculado correctamente (pero filtramos por año y curso de la matrícula elegida)
        if ($notasDefinitivas->isEmpty()) {
            $notasDefinitivas = \App\Models\NotasDefinitivas::where('documento_estudiante', $request->identificacion)
                ->where('grado_aprobado', 'LIKE', '%' . ($matricula->grado->nombre_grado ?? $request->grado_aprobado) . '%')
                ->where('curso', (string) $matricula->curso)
                ->whereHas('matriculaFinal', function ($q) use ($matricula) {
                    $q->where('ano_lectivo', $matricula->ano_lectivo);
                })
                ->get();
        }

        if ($notasDefinitivas->isEmpty()) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin notas',
                'text' => "No se encontraron notas definitivas registradas para el año {$matricula->ano_lectivo} en este grado."
            ]);
        }

        // 6. Enriquecer las notas con el "Nucleo" (Hilo) de la asignatura
        foreach ($notasDefinitivas as $nota) {
            $asignatura = \App\Models\Asignatura::with('hilo')
                ->where('nombre_asignatura', $nota->nombre_asignatura)
                ->first();
            $nota->nucleo = $asignatura->hilo->nombre_hilo ?? 'N/A';
        }

        $notasDefinitivas = $notasDefinitivas->sortBy('nucleo');

        $institucion = \App\Models\Institucion::first();

        $viewData = [
            'estudiante' => $estudiante,
            'grado_solicitado' => $request->grado_aprobado,
            'notas' => $notasDefinitivas,
            'matricula' => $matricula,
            'anho_lectivo' => $matricula->ano_lectivo,
            'fecha' => date('d/m/Y'),
            'institucion' => $institucion,
        ];

        $pdf = Pdf::loadView('Certificado.Pdf', $viewData);
        $pdf->setPaper('legal', 'portrait');

        return $pdf->download("Certificado_{$request->identificacion}_{$matricula->ano_lectivo}.pdf");
    }

    public function generarPorMatricula(Request $request, $id)
    {
        $matricula = \App\Models\MatriculaFinal::with(['grado.docente.user', 'sede', 'profesor'])->findOrFail($id);
        $periodo = null;
        if ($request->has('periodo_id')) {
            $periodo = PeriodoAcademico::find($request->periodo_id);
        }

        if ($matricula->estado === 'Retirado') {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Estudiante Retirado',
                'text' => 'No se puede generar certificado para una matrícula con estado Retirado (no cuenta con calificaciones definitivas).',
            ]);
        }

        $estudiante = \App\Models\Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])
            ->where('numero_identificacion_estudiante', $matricula->documento_estudiante)
            ->first();

        if (!$estudiante) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'No encontrado',
                'text' => 'No existe el estudiante asociado a esta matrícula.',
            ]);
        }

        // 2. Buscar notas por id_matricula (relación directa)
        // Agregamos filtro por curso para mayor precisión en casos de múltiples registros
        $notas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)
            ->where('curso', (string) $matricula->curso)
            ->get();

        // 3. Fallback: Si no hay notas vinculadas por ID, buscamos por documento, nombre de grado (parcial), año y CURSO
        if ($notas->isEmpty()) {
            $notas = \App\Models\NotasDefinitivas::where('documento_estudiante', $matricula->documento_estudiante)
                ->where('grado_aprobado', 'LIKE', '%' . ($matricula->grado->nombre_grado ?? '') . '%')
                ->where('curso', (string) $matricula->curso)
                ->whereHas('matriculaFinal', function ($q) use ($matricula) {
                    $q->where('ano_lectivo', $matricula->ano_lectivo);
                })
                ->get();
        }

        if ($notas->isEmpty()) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin notas',
                'text' => 'Este estudiante no tiene notas definitivas registradas para este curso y año.',
            ]);
        }

        // Enriquecer notas con Nucleo (Hilo)
        foreach ($notas as $nota) {
            $asignatura = \App\Models\Asignatura::with('hilo')
                ->where('nombre_asignatura', $nota->nombre_asignatura)
                ->first();
            $nota->nucleo = $asignatura?->hilo?->nombre_hilo ?? 'N/A';
        }

        $notas = $notas->sortBy('nucleo');

        $grado = $matricula->grado;
        $gradoAprobado = trim(($grado->nombre_grado ?? '') . ' - ' . ($grado->bloque ?? ''));

        $institucion = \App\Models\Institucion::first();

        $viewData = [
            'estudiante' => $estudiante,
            'grado_solicitado' => $gradoAprobado,
            'notas' => $notas,
            'matricula' => $matricula,
            'periodo' => $periodo,
            'anho_lectivo' => $matricula->ano_lectivo,
            'fecha' => date('d/m/Y'),
            'institucion' => $institucion,
        ];

        $nombreArchivo = "Certificado_{$matricula->documento_estudiante}_{$gradoAprobado}_{$matricula->ano_lectivo}.pdf";
        $nombreArchivo = str_replace([' ', '/'], '_', $nombreArchivo);

        $pdf = Pdf::loadView('Certificado.Pdf', $viewData);
        $pdf->setPaper('legal', 'portrait');

        return $pdf->download($nombreArchivo);
    }

    public function generarGrupo(Request $request)
    {
        $request->validate([
            'grado_id' => 'required|exists:grado_academicos,id',
            'ano_lectivo' => 'required|string',
        ]);

        $grado = \App\Models\GradoAcademico::with(['sede', 'docente.user', 'curso'])->findOrFail($request->grado_id);
        $gradoAprobado = trim(($grado->nombre_grado ?? '') . ' - ' . ($grado->bloque ?? ''));
        $periodo = $request->periodo_id ? PeriodoAcademico::find($request->periodo_id) : null;

        // 1. Obtener TODAS las matrículas del grado y año (excepto retirados)
        $queryMatriculas = \App\Models\MatriculaFinal::with(['grado.docente.user', 'sede', 'profesor'])
            ->where('id_grado', $request->grado_id)
            ->where('ano_lectivo', $request->ano_lectivo)
            ->where('estado', '!=', 'Retirado');

        if ($request->filled('curso')) {
            $queryMatriculas->where('curso', $request->curso);
        }

        $matriculas = $queryMatriculas->get();

        if ($matriculas->isEmpty()) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin alumnos',
                'text' => "No hay alumnos matriculados en {$gradoAprobado} para el año {$request->ano_lectivo}.",
            ]);
        }

        $bulkData = [];

        foreach ($matriculas as $matricula) {
            $estudiante = Estudiante::with(['user', 'acudiente.user'])
                ->where('numero_identificacion_estudiante', $matricula->documento_estudiante)
                ->first();

            if (!$estudiante)
                continue;

            // 2. Buscar notas por id_matricula (relación directa)
            $notas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)->get();

            // 3. Fallback: Si no hay notas por id_matricula, intentamos por documento, grado, año y CURSO
            if ($notas->isEmpty()) {
                $notas = \App\Models\NotasDefinitivas::where('documento_estudiante', $matricula->documento_estudiante)
                    ->where('grado_aprobado', 'LIKE', '%' . ($grado->nombre_grado ?? '') . '%')
                    ->where(function ($q) use ($matricula) {
                        $q->where('id_matricula', $matricula->id)
                            ->orWhere(function ($sq) use ($matricula) {
                                $sq->where('curso', $matricula->curso)
                                    ->whereHas('matriculaFinal', function ($ssq) use ($matricula) {
                                        $ssq->where('ano_lectivo', $matricula->ano_lectivo);
                                    });
                            });
                    })
                    ->get();
            }

            // 4. Si después del fallback sigue vacío (por ejemplo el estudiante fue retirado o no tiene notas en este curso/año)
            // lo omitimos para evitar reportes en blanco.
            if ($notas->isEmpty()) {
                continue;
            }

            // Enriquecer notas con Nucleo (Hilo)
            foreach ($notas as $nota) {
                $asignatura = \App\Models\Asignatura::with('hilo')
                    ->where('nombre_asignatura', $nota->nombre_asignatura)
                    ->first();
                $nota->nucleo = $asignatura?->hilo?->nombre_hilo ?? 'N/A';
            }

            $notas = $notas->sortBy('nucleo');

            $bulkData[] = [
                'estudiante' => $estudiante,
                'grado_solicitado' => $gradoAprobado,
                'notas' => $notas,
                'matricula' => $matricula,
                'anho_lectivo' => $request->ano_lectivo,
                'grado' => $grado,
            ];
        }

        if (empty($bulkData)) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin datos',
                'text' => "No se pudo construir el certificado grupal para {$gradoAprobado} - {$request->ano_lectivo}.",
            ]);
        }

        $nombreArchivo = str_replace([' ', '/'], '_', "Certificados_{$gradoAprobado}_{$request->ano_lectivo}.pdf");

        $institucion = \App\Models\Institucion::first();

        $pdf = Pdf::loadView('Certificado.PdfGrupo', [
            'bulkData' => $bulkData,
            'fecha' => date('d/m/Y'),
            'grado' => $grado,
            'periodo' => $periodo,
            'institucion' => $institucion,
        ]);
        $pdf->setPaper('legal', 'portrait');

        return $pdf->download($nombreArchivo);
    }
}
