<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;

class Hilo extends Model
{
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
