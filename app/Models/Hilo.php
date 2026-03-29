<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Asignatura;

use App\Traits\Auditable;

class Hilo extends Model
{
    use Auditable;
    protected $table = 'hilos';
    protected $fillable = [
        'nombre_hilo',
        'abreviatura',
        'estado',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
}
