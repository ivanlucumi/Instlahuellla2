<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\Auditable;

class CalificacionGradoCero extends Model
{
    use Auditable;
    protected $table = 'calificaciones_grado_cero';

    protected $fillable = [
        'estudiante_id',
        'criterio_id',
        'grado_academico_id',
        'periodo_id',
        'anho_escolar_id',
        'valor',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function criterio(): BelongsTo
    {
        return $this->belongsTo(CriterioGradoCero::class, 'criterio_id');
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
