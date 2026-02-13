<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Menu;


class InstitucionController extends Controller
{
    public function index()
    {
        $instituciones = Institucion::with('rector')->orderBy('id')->get();
        return view('Institucion.Index', compact('instituciones'));
    }

    public function create()
    {
        $existe = Institucion::exists();

        if ($existe) {
            return redirect()
                ->route('admin.institucion.edit', Institucion::first()->id)
                ->with('warning', 'Ya existe una institución registrada. Solo puede editarla.');
        }
        $rectores = User::orderBy('name')->get();
        return view('Institucion.Create', compact('rectores'));
    }

    public function store(Request $request)    
    {
        // 🔒 Validación
        $request->validate([
            'nombre_institucion'        => 'required|string|max:255',
            'descripcion_institucion'   => 'nullable|string',
            'codigo_dane'               => 'required|unique:institucions,codigo_dane',
            'ciudad_institucion'        => 'required|string|max:100',
            'departamento_institucion'  => 'required|string|max:100',
            'resolucion_institucion'    => 'nullable|string|max:255',
            'rector_id'                 => 'required|exists:users,id',
            //'favicon_institucion'       => 'nullable|image|mimes:png,jpg,jpeg,ico|max:2048',
        ]);
        
    
        // 🚫 Solo una institución
        if (Institucion::exists()) {
            return redirect()->back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Atención',
                'text'  => 'Ya existe una institución registrada. Solo se permite editar.'
            ]);
        }

        // 💾 Guardar
        Institucion::create([
            'nombre_institucion'       => $request->nombre_institucion,
            'descripcion_institucion'  => $request->descripcion_institucion,
            'codigo_dane'              => $request->codigo_dane,
            'ciudad_institucion'       => $request->ciudad_institucion,
            'departamento_institucion' => $request->departamento_institucion,
            'resolucion_institucion'   => $request->resolucion_institucion,
            'rector_id'                => $request->rector_id,
        ]);

        // ✅ Éxito
        return redirect()->route('admin.institucion.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'La institución fue registrada correctamente.'
        ]);
    try {

    } catch (Exception $e) {

        // 🧯 Log del error (MUY IMPORTANTE)
        \Log::error('Error al crear institución', [
            'error' => $e->getMessage(),
            'line'  => $e->getLine(),
            'file'  => $e->getFile(),
        ]);

        // ❌ Mensaje al usuario
        return redirect()->back()
            ->withInput()
            ->with('swal', [
                'icon'  => 'error',
                'title' => 'Error inesperado',
                'text'  => 'Ocurrió un problema al guardar la institución. Intente nuevamente.'
            ]);
    }
}

    public function edit(Institucion $institucion)
    {
        $rectores = User::orderBy('name')->get();
        $institucion = Institucion::first();
        //dd($institucion->id);
        return view('Institucion.Edit', compact('institucion', 'rectores'));
    }

    public function update(Request $request, Institucion $institucion)
    {
        $request->validate([
            'nombre_institucion'       => 'required|string',
            'codigo_dane'              => 'required|unique:institucions,codigo_dane,' . $institucion->id,
            'ciudad_institucion'       => 'required',
            'departamento_institucion' => 'required',
            'rector_id'                => 'required|exists:users,id',
            'resolucion_institucion'   => 'nullable|string',
        ]);

        $institucion->update($request->all());

        return redirect()
    ->route('admin.institucion.index')
    ->with('swal', [
        'icon'  => 'success',
        'title' => '¡Proceso exitoso!',
        'text'  => 'La institución fue guardada correctamente.'
    ]);
    }

    public function destroy(Institucion $institucion)
    {
        $institucion->delete();

        return redirect()->route('admin.institucion.index')
            ->with('success', 'Institución eliminada');
    }
}
