<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradoAcademico extends Model
{
    //
    protected $table = 'grado_academicos';
    protected $fillable = [
        'nombre_grado',
        'bloque',
        'sede_id',
        'docente_id',
        'curso_id',
        'asignatura_id',
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
        return $this->belongsTo(Docente::class, 'id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'grado_id');
    }
}
