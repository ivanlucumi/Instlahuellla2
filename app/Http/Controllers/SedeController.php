<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sede::query();

        if ($request->filled('search')) {
            $query->where('nombre_sede', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('direccion_sede', 'LIKE', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $sedes = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

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
            'zona_sede'          => 'nullable|string',
            'jornada'            => 'nullable|string',
        ]);

        // 💾 Guardar
        $data = $request->all();
        $data['estado_sede'] = $request->has('estado_sede') ? true : false;
        Sede::create($data);

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
            'zona_sede'          => 'nullable|string',
            'jornada'            => 'nullable|string',
        ]);

        // 💾 Actualizar
        $data = $request->all();
        $data['estado_sede'] = $request->has('estado_sede') ? true : false;
        $sede->update($data);

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
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $sede->delete();

        return redirect()->route('admin.sede.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La sede fue eliminada correctamente.'
        ]);
    }
}
