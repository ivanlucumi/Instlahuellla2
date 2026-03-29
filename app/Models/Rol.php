<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Menu;
use App\Models\RolUser;
use App\Models\User;

use App\Traits\Auditable;

class Rol extends Model
{
    use Auditable;
    //  Tabla
    protected $table = 'rol';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function rol()
    {
        return $this->hasMany(RolUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'rol_user', 'rol_id', 'user_id');
    }


}
