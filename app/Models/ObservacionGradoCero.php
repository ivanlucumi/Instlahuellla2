<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\Auditable;

class ObservacionGradoCero extends Model
{
    use Auditable;
    protected $table = 'observaciones_grado_cero';

    protected $fillable = [
        'estudiante_id',
        'grado_academico_id',
        'periodo_id',
        'anho_escolar_id',
        'observacion',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function gradoAcademico(): BelongsTo
    {
        return $this->belongsTo(GradoAcademico::class);
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_id');
    }

    public function anhoEscolar(): BelongsTo
    {
        return $this->belongsTo(AnhoEscolar::class, 'anho_escolar_id');
    }
}
