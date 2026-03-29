<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Docente extends Model
{
    use Auditable;
    //
    protected $table = 'docentes';
    protected $fillable = [
        'user_id',
        'codigo_docente',
        'genero_docente',
        'foto_docente',
        'estado_docente'
    ];

    protected $casts = [
        'estado_docente' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grados()
    {
        return $this->hasMany(GradoAcademico::class, 'docente_id');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_grado_docente', 'docente_id', 'asignatura_id', 'user_id', 'id')
                    ->withPivot('grado_academico_id')
                    ->withTimestamps();
    }
    
}
