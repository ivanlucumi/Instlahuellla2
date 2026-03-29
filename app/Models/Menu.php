<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Menu extends Model
{
    use Auditable;
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
