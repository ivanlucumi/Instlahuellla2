<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Notas extends Model
{
    use Auditable;

    protected $fillable = [
        'matriculado_id',
        'asignatura_id',
        'nota1',
        'nota2',
        'nota3',
        'nota4',
        'nota_definitiva',
        'observaciones',
        // Mantener opcionales por compatibilidad si es necesario
        'periodo_academico_id',
        'grado_id',
        'estudiante_id',
        'nota',
    ];

    public function matriculado()
    {
        return $this->belongsTo(Matriculado::class, 'matriculado_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grado()
    {
        return $this->belongsTo(GradoAcademico::class, 'grado_id');
    }
}
