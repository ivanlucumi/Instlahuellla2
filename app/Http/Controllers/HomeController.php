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
            return view('admin.Admin');
        }

        if ($user->hasRol('ESTUDIANTE')) {
            return redirect()->route('estudiante.dashboard');
        }

        if ($user->hasRol('DOCENTE')) {
            return redirect()->route('docente.dashboard');
        }

        // Default or for roles without specific dashboards yet
        return view('admin.Admin');
    }
}
