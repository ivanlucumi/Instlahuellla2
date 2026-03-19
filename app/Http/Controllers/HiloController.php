<?php

namespace App\Http\Controllers;

use App\Models\Hilo;
use Illuminate\Http\Request;

class HiloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Hilo::query();

        if ($request->filled('search')) {
            $query->where('nombre_hilo', 'LIKE', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $hilos = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

        return view('Hilo.Index', compact('hilos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Hilo.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_hilo' => 'required|string|max:255',
            'abreviatura' => 'required|string|max:10',
            'estado'      => 'required|in:activo,inactivo',
        ]);

        Hilo::create($request->all());

        return redirect()->route('admin.hilo.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El hilo fue registrado correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hilo $hilo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hilo $hilo)
    {
        return view('Hilo.Edit', compact('hilo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hilo $hilo)
    {
        $request->validate([
            'nombre_hilo' => 'required|string|max:255',
            'abreviatura' => 'required|string|max:10',
            'estado'      => 'required|in:activo,inactivo',
        ]);

        $hilo->update($request->all());

        return redirect()->route('admin.hilo.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El hilo fue actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hilo $hilo)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $hilo->delete();

        return redirect()->route('admin.hilo.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El hilo fue eliminado correctamente.'
        ]);
    }
}
