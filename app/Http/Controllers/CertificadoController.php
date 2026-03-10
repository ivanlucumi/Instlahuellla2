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
        $estudiantes = Estudiante::with('user')->get()->map(function($e) {
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

        // Buscar al estudiante por número de identificación
        $estudiante = Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])
            ->where('numero_identificacion_estudiante', $request->identificacion)
            ->first();

        if (!$estudiante) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'No encontrado',
                'text'  => 'No se encontró ningún estudiante con el número de identificación proporcionado.'
            ]);
        }

        // Obtener las notas definitivas para el estudiante y grado seleccionado
        $notasDefinitivas = \App\Models\NotasDefinitivas::where('documento_estudiante', $request->identificacion)
            ->where('grado_aprobado', $request->grado_aprobado)
            ->get();

        if ($notasDefinitivas->isEmpty()) {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Sin registros',
                'text'  => "No se encontraron notas definitivas para el estudiante en el grado {$request->grado_aprobado}."
            ]);
        }

        // Intentar obtener información de matrícula final para el contexto (sede, profesor)
        // Usamos el primer año que aparezca en las notas definitivas si es posible, o el año actual
        $matricula = \App\Models\MatriculaFinal::with(['grado', 'sede', 'profesor'])
            ->where('documento_estudiante', $request->identificacion)
            ->whereHas('grado', function($q) use ($request) {
                $q->where('nombre_grado', $request->grado_aprobado);
            })
            ->first();

        // Enriquecer las notas con el "Nucleo" (Hilo) de la asignatura
        foreach ($notasDefinitivas as $nota) {
            $asignatura = \App\Models\Asignatura::with('hilo')
                ->where('nombre_asignatura', $nota->nombre_asignatura)
                ->first();
            $nota->nucleo = $asignatura->hilo->nombre_hilo ?? 'N/A';
        }

        // Ordenar por nucleo para que la agrupación en la vista funcione
        $notasDefinitivas = $notasDefinitivas->sortBy('nucleo');

        $viewData = [
            'estudiante'       => $estudiante,
            'grado_solicitado' => $request->grado_aprobado,
            'notas'            => $notasDefinitivas,
            'matricula'        => $matricula,
            'anho_lectivo'     => $matricula->ano_lectivo ?? ($notasDefinitivas->first()->ano_lectivo ?? date('Y')),
            'fecha'            => date('d/m/Y'),
        ];

        $pdf = Pdf::loadView('Certificado.Pdf', $viewData);
        $pdf->setPaper('legal', 'portrait');

        return $pdf->download("Certificado_{$request->identificacion}_{$request->grado_aprobado}.pdf");
    }

    public function generarPorMatricula($id)
    {
        $matricula = \App\Models\MatriculaFinal::with(['grado', 'sede', 'profesor'])->findOrFail($id);

        $estudiante = Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])
            ->where('numero_identificacion_estudiante', $matricula->documento_estudiante)
            ->first();

        if (!$estudiante) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'No encontrado',
                'text'  => 'No existe el estudiante asociado a esta matrícula.',
            ]);
        }

        // Buscar notas por id_matricula (relación directa, más confiable)
        $notas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)->get();

        if ($notas->isEmpty()) {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Sin notas',
                'text'  => 'Este estudiante no tiene notas definitivas registradas para esta matrícula.',
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

        $viewData = [
            'estudiante'       => $estudiante,
            'grado_solicitado' => $gradoAprobado,
            'notas'            => $notas,
            'matricula'        => $matricula,
            'anho_lectivo'     => $matricula->ano_lectivo,
            'fecha'            => date('d/m/Y'),
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
            'grado_id'    => 'required|exists:grado_academicos,id',
            'ano_lectivo' => 'required|string',
        ]);

        $grado = \App\Models\GradoAcademico::with(['sede', 'docente.user', 'curso'])->findOrFail($request->grado_id);
        $gradoAprobado = trim(($grado->nombre_grado ?? '') . ' - ' . ($grado->bloque ?? ''));

        // 1. Obtener TODAS las matrículas del grado y año
        $queryMatriculas = \App\Models\MatriculaFinal::with(['sede', 'profesor'])
            ->where('id_grado', $request->grado_id)
            ->where('ano_lectivo', $request->ano_lectivo);

        if ($request->filled('curso')) {
            $queryMatriculas->where('curso', $request->curso);
        }

        $matriculas = $queryMatriculas->get();

        if ($matriculas->isEmpty()) {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Sin alumnos',
                'text'  => "No hay alumnos matriculados en {$gradoAprobado} para el año {$request->ano_lectivo}.",
            ]);
        }

        $bulkData = [];

        foreach ($matriculas as $matricula) {
            $estudiante = Estudiante::with(['user', 'acudiente.user'])
                ->where('numero_identificacion_estudiante', $matricula->documento_estudiante)
                ->first();

            if (!$estudiante) continue;

            // Buscar notas por id_matricula (relación directa)
            $notas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)->get();

            // Enriquecer notas con Nucleo (Hilo)
            foreach ($notas as $nota) {
                $asignatura = \App\Models\Asignatura::with('hilo')
                    ->where('nombre_asignatura', $nota->nombre_asignatura)
                    ->first();
                $nota->nucleo = $asignatura?->hilo?->nombre_hilo ?? 'N/A';
            }

            $notas = $notas->sortBy('nucleo');

            $bulkData[] = [
                'estudiante'       => $estudiante,
                'grado_solicitado' => $gradoAprobado,
                'notas'            => $notas,
                'matricula'        => $matricula,
                'anho_lectivo'     => $request->ano_lectivo,
                'grado'            => $grado,
            ];
        }

        if (empty($bulkData)) {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Sin datos',
                'text'  => "No se pudo construir el certificado grupal para {$gradoAprobado} - {$request->ano_lectivo}.",
            ]);
        }

        $nombreArchivo = str_replace([' ', '/'], '_', "Certificados_{$gradoAprobado}_{$request->ano_lectivo}.pdf");

        $pdf = Pdf::loadView('Certificado.PdfGrupo', [
            'bulkData' => $bulkData,
            'fecha'    => date('d/m/Y'),
            'grado'    => $grado,
        ]);
        $pdf->setPaper('legal', 'portrait');

        return $pdf->download($nombreArchivo);
    }
}
