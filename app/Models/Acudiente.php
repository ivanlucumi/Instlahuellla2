<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Acudiente extends Model
{
    use Auditable;
    //
    protected $table = 'acudientes';
    protected $fillable = [
        'user_id',
        'id_documento',
        'celular_acudiente',
        'direccion_acudiente',
        'genero_acudiente',
        'parentesco_acudiente',
        'estado_acudiente',
    ];

    protected $casts = [
        'estado_acudiente' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
