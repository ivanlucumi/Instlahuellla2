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
        'ano_lectivo',
        'fecha',
        'estado',
        'id_profesor',
        'documento_acudiente',
        'parentezco_acudiente',
    ];

    public function notasDefinitivas()
    {
        return $this->hasMany(NotasDefinitivas::class, 'id_matricula');
    }

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

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'documento_estudiante', 'numero_identificacion_estudiante');
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class, 'documento_acudiente', 'id_documento')->withDefault([
            'parentesco_acudiente' => 'Sin Acudiente'
        ]);
    }

    public function anoEscolarObj()
    {
        return $this->belongsTo(AnhoEscolar::class, 'ano_lectivo', 'nombre_anho_escolar');
    }
}

