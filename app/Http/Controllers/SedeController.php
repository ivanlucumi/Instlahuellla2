<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = Sede::with('institucion')->orderBy('id')->get();
        return view('Sede.Index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instituciones = \App\Models\Institucion::orderBy('nombre_institucion')->get();
        return view('Sede.Create', compact('instituciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔒 Validación
        $request->validate([
            'nombre_sede'        => 'required|string|max:255',
            'descripcion_sede'   => 'required|string',
            'codigo_dane_sede'   => 'required|string|unique:sedes,codigo_dane_sede',
            'resolucion_sede'    => 'required|string|max:255',
            'institucion_id'     => 'required|exists:institucions,id',
            'estado_sede'        => 'nullable|boolean',
        ]);

        // 💾 Guardar
        Sede::create([
            'nombre_sede'       => $request->nombre_sede,
            'descripcion_sede'  => $request->descripcion_sede,
            'codigo_dane_sede'  => $request->codigo_dane_sede,
            'resolucion_sede'   => $request->resolucion_sede,
            'institucion_id'    => $request->institucion_id,
            'estado_sede'       => $request->has('estado_sede') ? true : false,
        ]);

        // ✅ Éxito
        return redirect()->route('admin.sede.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'La sede fue registrada correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        $instituciones = \App\Models\Institucion::orderBy('nombre_institucion')->get();
        return view('Sede.Edit', compact('sede', 'instituciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $sede)
    {
        // 🔒 Validación
        $request->validate([
            'nombre_sede'        => 'required|string|max:255',
            'descripcion_sede'   => 'required|string',
            'codigo_dane_sede'   => 'required|string|unique:sedes,codigo_dane_sede,' . $sede->id,
            'resolucion_sede'    => 'required|string|max:255',
            'institucion_id'     => 'required|exists:institucions,id',
            'estado_sede'        => 'nullable|boolean',
        ]);

        // 💾 Actualizar
        $sede->update([
            'nombre_sede'       => $request->nombre_sede,
            'descripcion_sede'  => $request->descripcion_sede,
            'codigo_dane_sede'  => $request->codigo_dane_sede,
            'resolucion_sede'   => $request->resolucion_sede,
            'institucion_id'    => $request->institucion_id,
            'estado_sede'       => $request->has('estado_sede') ? true : false,
        ]);

        // ✅ Éxito
        return redirect()->route('admin.sede.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'La sede fue actualizada correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        $sede->delete();

        return redirect()->route('admin.sede.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La sede fue eliminada correctamente.'
        ]);
    }
}
