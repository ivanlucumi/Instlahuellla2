<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menu';

    protected $fillable = [
        'nombre',
        'nombre_submenu',
        'icono',
        'url',
        'tipo',
        'estado',
        'rol_id',
        'orden'
    ];

    public function esDropdown(): bool
    {
        return $this->tipo === 'dropdown';
    }
    
    public function esSubmenu(): bool
    {
        return !is_null($this->nombre_submenu);
    }
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

}
