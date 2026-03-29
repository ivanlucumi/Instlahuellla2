<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Sede extends Model
{
    use Auditable;
    //
    protected $table = 'sedes';
    protected $fillable = [
        'nombre_sede',
        'descripcion_sede',
        'codigo_dane_sede',
        'resolucion_sede',
        'institucion_id',
        'estado_sede',
        'zona_sede',
        'jornada'
    ];

    protected $casts = [
        'estado_sede' => 'boolean',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
