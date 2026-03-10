<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;

class Curso extends Model
{
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
