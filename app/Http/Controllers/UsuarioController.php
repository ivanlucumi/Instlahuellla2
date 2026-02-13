<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function crear()
    {
        return view('admin.usuarios.crear');
    }
    public function asignarRol()
    {
        return view('admin.usuarios.asignar-rol');
    }   
}
