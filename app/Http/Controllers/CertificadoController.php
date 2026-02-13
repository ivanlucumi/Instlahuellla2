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
        $estudiantes = Estudiante::with('user')->get()->sortBy('user.name');
        $anhos = AnhoEscolar::orderBy('nombre_anho_escolar', 'desc')->get();

        return view('Certificado.Index', compact('estudiantes', 'anhos'));
    }

    /**
     * Genera el PDF del certificado de notas.
     */
    public function generar(Request $request)
    {
        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'anho_escolar_id' => 'required|exists:anho_escolar,id',
        ]);

        $estudiante = Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])->findOrFail($request->estudiante_id);
        $anhoEscolar = AnhoEscolar::findOrFail($request->anho_escolar_id);

        // Obtener los periodos académicos de ese año
        $periodos = PeriodoAcademico::where('año_escolar_id', $anhoEscolar->id)
            ->orderBy('nombre_periodo')
            ->get();

        if ($periodos->isEmpty()) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'No hay periodos académicos registrados para el año seleccionado.'
            ]);
        }

        // Obtener todas las notas del estudiante para esos periodos
        $notasRaw = Notas::with('asignatura')
            ->where('estudiante_id', $estudiante->id)
            ->whereIn('periodo_academico_id', $periodos->pluck('id'))
            ->get();

        if ($notasRaw->isEmpty()) {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Sin información',
                'text'  => 'El estudiante no tiene notas registradas para el año escolar seleccionado.'
            ]);
        }

        // Organizar notas por asignatura y periodo
        $asignaturas = [];
        foreach ($notasRaw as $nota) {
            $asignaturaId = $nota->asignatura_id;
            $asignaturaNombre = $nota->asignatura->nombre_asignatura;
            
            if (!isset($asignaturas[$asignaturaId])) {
                $asignaturas[$asignaturaId] = [
                    'nombre' => $asignaturaNombre,
                    'notas'  => array_fill_keys($periodos->pluck('id')->toArray(), null),
                ];
            }
            $asignaturas[$asignaturaId]['notas'][$nota->periodo_academico_id] = $nota->nota;
        }

        // Calcular promedios finales
        foreach ($asignaturas as &$data) {
            $sum = 0;
            $count = 0;
            foreach ($data['notas'] as $notaValue) {
                if ($notaValue !== null) {
                    $sum += $notaValue;
                    $count++;
                }
            }
            $data['promedio'] = $count > 0 ? round($sum / $count, 2) : 0;
        }
        unset($data); // Importante: Eliminar referencia para evitar corromper el arreglo

        $viewData = [
            'estudiante'  => $estudiante,
            'anhoEscolar' => $anhoEscolar,
            'periodos'    => $periodos,
            'asignaturas' => $asignaturas,
            'fecha'       => date('d/m/Y'),
        ];

        $pdf = Pdf::loadView('Certificado.Pdf', $viewData);
        
        // Configurar papel
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream("Certificado_{$estudiante->user->name}_{$anhoEscolar->nombre_anho_escolar}.pdf");
    }
}
