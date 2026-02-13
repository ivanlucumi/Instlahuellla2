<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
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
