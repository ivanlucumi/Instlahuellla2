<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Traits\Auditable;

class Institucion extends Model
{
    use Auditable;
    //
    protected $table = 'institucions';
    protected $fillable = [
        'nombre_institucion',
        'descripcion_institucion',
        'codigo_dane',
        'ciudad_institucion',
        'departamento_institucion',
        'resolucion_institucion',
        'rector_id',
        'jerarquia',
        'calendario',
        'sector',
        'modelo',
        'jornada',
    ];

    public function rector()
    {
        return $this->belongsTo(User::class, 'rector_id');
    }

    public function sedes()
    {
        return $this->hasMany(Sede::class, 'institucion_id');
    }
}
