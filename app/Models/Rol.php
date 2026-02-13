<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\RolUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
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
