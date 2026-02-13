<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Sede;
use App\Models\Hilo;
use App\Models\User;
use App\Models\GradoAcademico;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    protected $fillable = [
        'nombre_asignatura',
        'nivel_educativo',
        'sede_id',
        'hilo_id',
        'descripcion',
        'creditos',
        'docente_id',
        'estado',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function hilo()
    {
        return $this->belongsTo(Hilo::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function grado()
    {
        return $this->belongsTo(GradoAcademico::class, 'grado_id');
    }
    
}
