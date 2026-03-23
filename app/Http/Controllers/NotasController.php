<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Notas::with(['matriculado.estudiante.user', 'matriculado.grado', 'asignatura'])->orderBy('id')->paginate(15);
        return view('Notas.Index', compact('notas'));
    }

    public function create()
    {
        $matriculados = \App\Models\Matriculado::with(['estudiante.user', 'grado'])->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();

        return view('Notas.Create', compact('matriculados', 'asignaturas'));
    }

    public function store(Request $request)
    {
        $notas = [$request->nota1, $request->nota2, $request->nota3, $request->nota4];
        $hasNotes = count(array_filter($notas, fn($n) => $n !== null && $n !== '')) > 0;

        if (!$hasNotes) {
            return back()->with('swal', [
                'icon'  => 'info',
                'title' => 'Sin notas',
                'text'  => 'Debe ingresar al menos una nota para registrar.'
            ])->withInput();
        }

        $request->validate([
            'matriculado_id' => 'required|exists:matriculados,id',
            'asignatura_id'  => 'required|exists:asignaturas,id',
            'nota1'          => 'nullable|numeric|min:0|max:5',
            'nota2'          => 'nullable|numeric|min:0|max:5',
            'nota3'          => 'nullable|numeric|min:0|max:5',
            'nota4'          => 'nullable|numeric|min:0|max:5',
            'observaciones'  => 'required|string|max:255',
        ], [
            'observaciones.required' => 'Las observaciones son obligatorias al asignar calificaciones.'
        ]);

        $data = $request->all();
        
        // Calcular definitiva
        $validNotas = array_filter($notas, fn($n) => $n !== null && $n !== '');
        $data['nota_definitiva'] = count($validNotas) > 0 ? array_sum($validNotas) / count($validNotas) : 0;

        Notas::create($data);

        return redirect()->route('admin.notas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'La nota fue registrada correctamente.'
        ]);
    }

    public function show(Notas $nota)
    {
        //
    }

    public function edit(Notas $nota)
    {
        $matriculados = \App\Models\Matriculado::with(['estudiante.user', 'grado'])->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();

        return view('Notas.Edit', compact('nota', 'matriculados', 'asignaturas'));
    }

    public function update(Request $request, Notas $nota)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN') || auth()->user()->hasRol('RECTOR'), 403, 'No tiene permisos para modificar calificaciones almacenadas.');
        
        $notas = [$request->nota1, $request->nota2, $request->nota3, $request->nota4];
        $hasNotes = count(array_filter($notas, fn($n) => $n !== null && $n !== '')) > 0;

        if (!$hasNotes) {
            return back()->with('swal', [
                'icon'  => 'info',
                'title' => 'Sin notas',
                'text'  => 'Debe ingresar al menos una nota o mantener las existentes.'
            ])->withInput();
        }

        $request->validate([
            'matriculado_id' => 'required|exists:matriculados,id',
            'asignatura_id'  => 'required|exists:asignaturas,id',
            'nota1'          => 'nullable|numeric|min:0|max:5',
            'nota2'          => 'nullable|numeric|min:0|max:5',
            'nota3'          => 'nullable|numeric|min:0|max:5',
            'nota4'          => 'nullable|numeric|min:0|max:5',
            'observaciones'  => 'required|string|max:255',
        ], [
            'observaciones.required' => 'Las observaciones son obligatorias al asignar calificaciones.'
        ]);

        $data = $request->all();

        // Calcular definitiva
        $validNotas = array_filter($notas, fn($n) => $n !== null && $n !== '');
        $data['nota_definitiva'] = count($validNotas) > 0 ? array_sum($validNotas) / count($validNotas) : 0;

        $nota->update($data);

        return redirect()->route('admin.notas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'La nota fue actualizada correctamente.'
        ]);
    }

    public function destroy(Notas $nota)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN') || auth()->user()->hasRol('RECTOR'), 403, 'Solo el Rector o Súper Administrador pueden eliminar registros.');

        $nota->delete();

        return redirect()->route('admin.notas.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La nota fue eliminada correctamente.'
        ]);
    }
}
