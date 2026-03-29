<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Asignatura;

use App\Traits\Auditable;

class AnhoEscolar extends Model
{
    use Auditable;
    protected $table = 'anho_escolar';
    protected $fillable = [
        'nombre_anho_escolar',
        'fecha_inicio_anho_escolar',
        'fecha_fin_anho_escolar',
        'estado_anho_escolar',
        'descripcion_anho_escolar',
    ];

    protected $casts = [
        'fecha_inicio_anho_escolar' => 'date',
        'fecha_fin_anho_escolar'    => 'date',
        'estado_anho_escolar'       => 'boolean',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    public function periodosAcademicos()
    {
        return $this->hasMany(PeriodoAcademico::class, 'año_escolar_id');
    }

    public function matriculados()
    {
        return $this->hasMany(Matriculado::class, 'anho_escolar_id');
    }
}
