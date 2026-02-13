<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class NotasDefinitivas extends Model
{
    use Auditable;

    protected $fillable = [
        'documento_estudiante',
        'nombre_estudiante',
        'grado_aprobado',
        'nota_per1',
        'nota_per2',
        'nota_per3',
        'nota_per4',
        'nota_definitiva',
        'nombre_asignatura',
        'curso',
    ];
}
