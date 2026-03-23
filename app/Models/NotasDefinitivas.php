<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class NotasDefinitivas extends Model
{
    protected $fillable = [
        'id_matricula',
        'asignatura_id',
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
        'observaciones',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    public function matriculaFinal()
    {
        return $this->belongsTo(MatriculaFinal::class, 'id_matricula');
    }
}
