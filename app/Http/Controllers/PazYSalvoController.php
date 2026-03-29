<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PazYSalvoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_secure:SUPERADMIN,ADMIN']);
    }

    public function index()
    {
        // Placeholder for now
        return view('admin.pazysalvo.index');
    }

    public function generar(Request $request)
    {
        // Placeholder for now
        return back()->with('swal', [
            'icon' => 'info',
            'title' => 'Módulo en desarrollo',
            'text' => 'La funcionalidad de generación de Paz y Salvo estará disponible próximamente.'
        ]);
    }
}
