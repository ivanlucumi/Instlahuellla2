<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Traits\Auditable;

class Matriculado extends Model
{
    use Auditable;

    protected $fillable = [
        'estudiante_id',
        'asignatura_id',
        'acudiente_id',
        'grado_id',
        'anho_escolar_id',
        'estado',
        'fecha_matricula',
        'observaciones',
    ];

    protected $casts = [
        'fecha_matricula' => 'date',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class);
    }

    public function grado()
    {
        return $this->belongsTo(GradoAcademico::class, 'grado_id');
    }

    public function anhoEscolar()
    {
        return $this->belongsTo(AnhoEscolar::class, 'anho_escolar_id');
    }
}
