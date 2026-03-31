<?php

namespace App\Models;
use App\Models\Menu;
use App\Models\Rol;
use App\Models\RolUser;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Traits\Auditable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'new_email',
        'genero',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    

     public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_user', 'user_id', 'rol_id');
    }


    public function menus()
    {
        $rolesIds = $this->roles->pluck('id')->toArray();
        
        return Menu::whereIn('rol_id', $rolesIds)
            ->where('estado', true)
            ->orderBy('orden')
            ->get()
            // Descartar duplicados si el usuario tiene múltiples roles con acceso al mismo menú
            ->unique(function ($item) {
                return $item->nombre . $item->nombre_submenu . $item->url;
            })
            ->sortBy('orden')
            ->groupBy('nombre');
    }
    
    public function hasRol($rol)
    {
        return $this->roles()->where('nombre', $rol)->exists();
    }
    
    


    public function docente()
    {
        return $this->hasOne(Docente::class);
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    public function acudiente()
    {
        return $this->hasOne(Acudiente::class);
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_grado_docente', 'docente_id', 'asignatura_id')
                    ->withPivot('grado_academico_id')
                    ->withTimestamps();
    }

    public function grados()
    {
        return $this->hasManyThrough(GradoAcademico::class, Docente::class, 'user_id', 'docente_id');
    }

}
