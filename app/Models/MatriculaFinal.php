<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatriculaFinal extends Model
{
    protected $table = 'matricula_finals';

    protected $fillable = [
        'documento_estudiante',
        'id_sede',
        'id_grado',
        'curso',
        'año_lectivo',
        'fecha',
        'estado',
        'id_profesor',
        'documento_acudiente',
        'parentezco_acudiente',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    public function grado()
    {
        return $this->belongsTo(GradoAcademico::class, 'id_grado');
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor');
    }
}
