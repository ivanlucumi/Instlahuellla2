<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
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
    return $this->belongsToMany(
        Asignatura::class,
        'docente_asignatura',
        'docente_id',
        'asignatura_id'
    );
}
    
}
