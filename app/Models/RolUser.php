<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolUser extends Model
{
    //
    protected $table = 'rol_user';
    protected $fillable = [
        'rol_id',
        'user_id'
    ];
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
