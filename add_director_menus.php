<?php

use App\Models\Menu;
use App\Models\Rol;

$directorRole = Rol::where('nombre', 'DIRECTOR')->first();
if (!$directorRole) {
    echo "Director role not found\n";
    exit;
}

$urlsToCopy = [
    'admin.asignatura.index',
    'admin.gradoacademico.index',
    'admin.acudiente.index',
    'admin.estudiante.index',
    'admin.matriculado.index',
    'admin.certificados.index',
    'docente.dashboard',
];

$count = 0;
foreach ($urlsToCopy as $url) {
    // get a template menu
    $template = Menu::where('url', $url)->first();
    if ($template) {
        $exists = Menu::where('url', $url)->where('rol_id', $directorRole->id)->exists();
        if (!$exists) {
            $newMenu = $template->replicate();
            $newMenu->rol_id = $directorRole->id;
            $newMenu->save();
            echo "Added menu {$newMenu->nombre} for DIRECTOR\n";
            $count++;
        }
    }
}

echo "Added $count new menus for DIRECTOR\n";
