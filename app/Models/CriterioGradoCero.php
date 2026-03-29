<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\Auditable;

class CriterioGradoCero extends Model
{
    use Auditable;
    protected $table = 'criterios_grado_cero';

    protected $fillable = [
        'asignatura_id',
        'nombre_criterio',
        'estado',
    ];

    public function asignatura(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(CalificacionGradoCero::class, 'criterio_id');
    }
    
}
