<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$matricula = \App\Models\MatriculaFinal::with(['grado.docente.user', 'sede', 'profesor'])->find(120);
if (!$matricula) {
    echo "No matricula found for ID 120\n";
    $matricula = \App\Models\MatriculaFinal::with(['grado.docente.user', 'sede', 'profesor'])->first();
    if (!$matricula) {
        echo "No matriculas at all\n";
        exit;
    }
    echo "Using matricula " . $matricula->id . "\n";
}

$estudiante = \App\Models\Estudiante::with(['user', 'gradoAcademico', 'acudiente.user'])
    ->where('numero_identificacion_estudiante', $matricula->documento_estudiante)
    ->first();
    
$notas = \App\Models\NotasDefinitivas::where('id_matricula', $matricula->id)
    ->where('curso', (string) $matricula->curso)
    ->get();
if ($notas->isEmpty()) {
    $notas = \App\Models\NotasDefinitivas::where('documento_estudiante', $matricula->documento_estudiante)
        ->where('grado_aprobado', 'LIKE', '%' . ($matricula->grado->nombre_grado ?? '') . '%')
        ->where('curso', (string) $matricula->curso)
        ->get();
}
foreach ($notas as $nota) {
    if (!$nota->nombre_asignatura) continue;
    $asignatura = \App\Models\Asignatura::with('hilo')->where('nombre_asignatura', $nota->nombre_asignatura)->first();
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
    'periodo' => null,
    'anho_lectivo' => $matricula->ano_lectivo,
    'fecha' => date('d/m/Y'),
    'institucion' => $institucion,
];

try {
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Certificado.Pdf', $viewData);
    $pdf->setPaper('legal', 'portrait');
    $pdf->save('C:/Users/IvanCamiloLucumiGarc/.gemini/antigravity/brain/ed1aab18-4160-4334-bbfe-a1db79a5b3cb/artifacts/boletin_prueba.pdf');
    echo "PDF generated successfully\n";
} catch (\Exception $e) {
    echo "Error generating PDF: " . $e->getMessage() . "\n";
}
