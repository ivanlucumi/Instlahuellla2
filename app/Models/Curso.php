<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;

use App\Traits\Auditable;

class Curso extends Model
{
    use Auditable;
    protected $table = 'cursos';
    protected $fillable = [
        'nombre_curso',
        'descripcion',
        'estado',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    public function grados()
    {
        return $this->hasMany(GradoAcademico::class);
    }
}
