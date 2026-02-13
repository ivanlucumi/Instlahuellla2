<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    //
    protected $table = 'sedes';
    protected $fillable = [
        'nombre_sede',
        'descripcion_sede',
        'codigo_dane_sede',
        'resolucion_sede',
        'institucion_id',
        'estado_sede'
    ];

    protected $casts = [
        'estado_sede' => 'boolean',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
