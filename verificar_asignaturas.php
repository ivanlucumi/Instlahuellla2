<?php

use Illuminate\Support\Facades\DB;

// Contar asignaturas por nivel
$primaria = DB::table('asignaturas')->where('nivel_educativo', 'primaria')->count();
$secundaria = DB::table('asignaturas')->where('nivel_educativo', 'secundaria')->count();

echo "PRIMARIA: $primaria asignaturas\n";
echo "SECUNDARIA: $secundaria asignaturas\n\n";

// Listar todas las asignaturas
$asignaturas = DB::table('asignaturas')
    ->select('nombre_asignatura', 'nivel_educativo')
    ->orderBy('nivel_educativo')
    ->orderBy('nombre_asignatura')
    ->get();

echo "LISTADO COMPLETO:\n";
echo str_repeat('-', 60) . "\n";

foreach ($asignaturas as $asignatura) {
    $nivel = strtoupper($asignatura->nivel_educativo);
    echo sprintf("%-12s | %s\n", $nivel, $asignatura->nombre_asignatura);
}
