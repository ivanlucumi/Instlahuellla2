<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRol('DIRECTOR')) {
            return redirect()->route('director.dashboard');
        }

        if ($user->hasRol('ESTUDIANTE')) {
            return redirect()->route('estudiante.dashboard');
        }

        if ($user->hasRol('DOCENTE')) {
            return redirect()->route('docente.dashboard');
        }

        // Si llega aquí y tiene acceso, mostrar un dashboard genérico o el de admin
        $institucion = \App\Models\Institucion::first();
        return view('admin.Admin', compact('institucion'));
    }

    public function adminDashboard()
    {
        $institucion = \App\Models\Institucion::first();
        return view('admin.Admin', compact('institucion'));
    }

    public function directorDashboard()
    {
        $institucion = \App\Models\Institucion::first();
        // Podríamos pasar más datos específicos para directores aquí
        return view('admin.Admin', compact('institucion')); // Por ahora usan la misma vista base
    }
}
