<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodoAcademico extends Model
{
    protected $table = 'periodo_academicos';

    protected $fillable = [
        'año_escolar_id',
        'nombre_periodo',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje_periodo',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function anhoEscolar()
    {
        return $this->belongsTo(AnhoEscolar::class, 'año_escolar_id');
    }

    public function gradosAcademicos()
    {
        return $this->hasMany(GradoAcademico::class);
    }
}
