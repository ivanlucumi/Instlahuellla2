<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Traits\Auditable;

class GradoAcademico extends Model
{
    use Auditable;
    //
    protected $table = 'grado_academicos';
    protected $fillable = [
        'nombre_grado',
        'bloque',
        'sede_id',
        'curso_id',
        'asignatura_id',
        'docente_id',
        'estado_grado_academico'
    ];

    protected $casts = [
        'estado_grado_academico' => 'boolean',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'grado_academico_id');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_grado_docente', 'grado_academico_id', 'asignatura_id')
                    ->withPivot('docente_id')
                    ->withTimestamps();
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
