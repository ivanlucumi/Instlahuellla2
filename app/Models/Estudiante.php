<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Traits\Auditable;

class Estudiante extends Model
{
    use Auditable;
    protected $table = 'estudiantes';

    protected $fillable = [
        'user_id',
        'codigo_estudiante',
        'fecha_nacimiento_estudiante',
        'genero_estudiante',
        'foto_estudiante',
        'anho_curso_estudiante',
        'direccion_estudiante',
        'telefono_estudiante',
        'email_estudiante',
        'tipo_identificacion_estudiante',
        'numero_identificacion_estudiante',
        'estado_estudiante',
        'acudiente_id',
        'grado_academico_id',
    ];

    protected $casts = [
        'fecha_nacimiento_estudiante' => 'date',
        'estado_estudiante' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class);
    }

    public function gradoAcademico()
    {
        return $this->belongsTo(GradoAcademico::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matriculado::class);
    }

    public function notas()
    {
        return $this->hasMany(Notas::class);
    }

    public function matriculasFinales()
    {
        return $this->hasMany(MatriculaFinal::class, 'documento_estudiante', 'numero_identificacion_estudiante');
    }
}
