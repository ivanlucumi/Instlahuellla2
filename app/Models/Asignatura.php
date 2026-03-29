<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hilo;
use App\Models\GradoAcademico;

use App\Traits\Auditable;

class Asignatura extends Model
{
    use Auditable;
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

    public function docentes()
    {
        return $this->belongsToMany(User::class, 'asignatura_grado_docente', 'asignatura_id', 'docente_id')
                    ->withPivot('grado_academico_id')
                    ->withTimestamps();
    }
    
}
