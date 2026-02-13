<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Notas extends Model
{
    use Auditable;

    protected $fillable = [
        'periodo_academico_id',
        'grado_id',
        'estudiante_id',
        'nota',
        'observaciones',
        'asignatura_id',
    ];

    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    public function grado()
    {
        return $this->belongsTo(GradoAcademico::class, 'grado_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
