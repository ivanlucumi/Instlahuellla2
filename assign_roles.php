<?php

use App\Models\User;
use App\Models\Acudiente;
use App\Models\Estudiante;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

DB::transaction(function() {
    $rolAcudiente = Rol::where('nombre', 'ACUDIENTE')->first();
    $rolEstudiante = Rol::where('nombre', 'ESTUDIANTE')->first();

    if ($rolAcudiente) {
        $acudientes = Acudiente::whereNotNull('user_id')->get();
        foreach ($acudientes as $acudiente) {
            $user = User::find($acudiente->user_id);
            if ($user && !$user->roles->contains($rolAcudiente->id)) {
                $user->roles()->attach($rolAcudiente->id);
                echo "Role ACUDIENTE assigned to User: {$user->email}\n";
            }
        }
    }

    if ($rolEstudiante) {
        $estudiantes = Estudiante::whereNotNull('user_id')->get();
        foreach ($estudiantes as $estudiante) {
            $user = User::find($estudiante->user_id);
            if ($user && !$user->roles->contains($rolEstudiante->id)) {
                $user->roles()->attach($rolEstudiante->id);
                echo "Role ESTUDIANTE assigned to User: {$user->email}\n";
            }
        }
    }
});

echo "Roles updated successfully.\n";
