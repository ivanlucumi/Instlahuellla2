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
        $notas = Notas::with(['periodoAcademico', 'grado', 'estudiante.user', 'asignatura'])->orderBy('id')->paginate(15);
        return view('Notas.Index', compact('notas'));
    }

    public function create()
    {
        $periodos = \App\Models\PeriodoAcademico::orderBy('nombre_periodo')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        // Cargar estudiantes con relacion user
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();

        return view('Notas.Create', compact('periodos', 'grados', 'estudiantes', 'asignaturas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo_academico_id' => 'required|exists:periodo_academicos,id',
            'grado_id'             => 'required|exists:grado_academicos,id',
            'estudiante_id'        => 'required|exists:estudiantes,id',
            'asignatura_id'        => 'required|exists:asignaturas,id',
            'nota'                 => 'required|numeric|min:0|max:5', // Asumiendo escala de 0 a 5
            'observaciones'        => 'nullable|string|max:255',
        ]);

        Notas::create($request->all());

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
        $periodos = \App\Models\PeriodoAcademico::orderBy('nombre_periodo')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();

        return view('Notas.Edit', compact('nota', 'periodos', 'grados', 'estudiantes', 'asignaturas'));
    }

    public function update(Request $request, Notas $nota)
    {
        $request->validate([
            'periodo_academico_id' => 'required|exists:periodo_academicos,id',
            'grado_id'             => 'required|exists:grado_academicos,id',
            'estudiante_id'        => 'required|exists:estudiantes,id',
            'asignatura_id'        => 'required|exists:asignaturas,id',
            'nota'                 => 'required|numeric|min:0|max:5',
            'observaciones'        => 'nullable|string|max:255',
        ]);

        $nota->update($request->all());

        return redirect()->route('admin.notas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'La nota fue actualizada correctamente.'
        ]);
    }

    public function destroy(Notas $nota)
    {
        $nota->delete();

        return redirect()->route('admin.notas.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La nota fue eliminada correctamente.'
        ]);
    }
}
