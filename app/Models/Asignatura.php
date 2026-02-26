<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hilo;
use App\Models\GradoAcademico;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    protected $fillable = [
        'nombre_asignatura',
        'nivel_educativo',
        'hilo_id',
        'estado',
    ];


    public function hilo()
    {
        return $this->belongsTo(Hilo::class);
    }
    public function grados()
    {
        return $this->belongsToMany(GradoAcademico::class, 'asignatura_grado_docente', 'asignatura_id', 'grado_academico_id')
                    ->withPivot('docente_id')
                    ->withTimestamps();
    }
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function docentes()
    {
        return $this->belongsToMany(User::class, 'asignatura_grado_docente', 'asignatura_id', 'docente_id')
                    ->withPivot('grado_academico_id')
                    ->withTimestamps();
    }
    
}
