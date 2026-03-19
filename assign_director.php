<?php

use App\Models\Rol;
use App\Models\GradoAcademico;
use App\Models\Docente;

// Create or update the DIRECTOR role
$directorRole = Rol::firstOrCreate(
    ['nombre' => 'DIRECTOR'],
    ['descripcion' => 'Director de Grado Académico', 'estado' => 1]
);

$grados = GradoAcademico::whereNotNull('docente_id')->get();
$count = 0;

foreach ($grados as $grado) {
    if ($grado->docente && $grado->docente->user) {
        $user = $grado->docente->user;
        if (!$user->roles()->where('nombre', 'DIRECTOR')->exists()) {
            $user->roles()->attach($directorRole->id);
            echo "Assigned DIRECTOR role to user {$user->name} (Docente ID: {$grado->docente_id})\n";
            $count++;
        }
    }
}

echo "Total directors assigned: $count\n";
