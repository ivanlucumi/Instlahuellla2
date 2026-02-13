<?php

namespace App\Http\Controllers;

use App\Models\GradoAcademico;
use Illuminate\Http\Request;

class GradoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grados = GradoAcademico::with(['sede', 'docente.user', 'curso', 'asignatura'])->orderBy('id')->paginate(15);
        return view('GradoAcademico.Index', compact('grados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sedes = \App\Models\Sede::orderBy('nombre_sede')->get();
        $docentes = \App\Models\Docente::with('user')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        return view('GradoAcademico.Create', compact('sedes', 'docentes', 'cursos', 'asignaturas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_grado'           => 'required|string|max:255',
            'bloque'                 => 'required|string|max:255',
            'sede_id'                => 'required|exists:sedes,id',
            'docente_id'             => 'required|exists:docentes,id',
            'curso_id'               => 'nullable|exists:cursos,id',
            'asignatura_id'          => 'nullable|exists:asignaturas,id',
            'estado_grado_academico' => 'nullable|boolean',
        ]);

        GradoAcademico::create([
            'nombre_grado'           => $request->nombre_grado,
            'bloque'                 => $request->bloque,
            'sede_id'                => $request->sede_id,
            'docente_id'             => $request->docente_id,
            'curso_id'               => $request->curso_id,
            'asignatura_id'          => $request->asignatura_id,
            'estado_grado_academico' => $request->has('estado_grado_academico') ? 1 : 0,
        ]);

        return redirect()->route('admin.gradoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El grado académico fue registrado correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(GradoAcademico $gradoAcademico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradoAcademico $gradoAcademico)
    {
        $sedes = \App\Models\Sede::orderBy('nombre_sede')->get();
        $docentes = \App\Models\Docente::with('user')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        return view('GradoAcademico.Edit', compact('gradoAcademico', 'sedes', 'docentes', 'cursos', 'asignaturas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradoAcademico $gradoAcademico)
    {
        $request->validate([
            'nombre_grado'           => 'required|string|max:255',
            'bloque'                 => 'required|string|max:255',
            'sede_id'                => 'required|exists:sedes,id',
            'docente_id'             => 'required|exists:docentes,id',
            'curso_id'               => 'nullable|exists:cursos,id',
            'asignatura_id'          => 'nullable|exists:asignaturas,id',
            'estado_grado_academico' => 'nullable|boolean',
        ]);

        $gradoAcademico->update([
            'nombre_grado'           => $request->nombre_grado,
            'bloque'                 => $request->bloque,
            'sede_id'                => $request->sede_id,
            'docente_id'             => $request->docente_id,
            'curso_id'               => $request->curso_id,
            'asignatura_id'          => $request->asignatura_id,
            'estado_grado_academico' => $request->has('estado_grado_academico') ? 1 : 0,
        ]);

        return redirect()->route('admin.gradoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El grado académico fue actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradoAcademico $gradoAcademico)
    {
        $gradoAcademico->delete();

        return redirect()->route('admin.gradoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El grado académico fue eliminado correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
        $request->validate([
            'nombre_grado' => 'required|string|max:255',
            'bloque'       => 'required|string|max:255',
        ]);

        try {
            $sede = \App\Models\Sede::first();
            $docente = \App\Models\Docente::first();

            $grado = GradoAcademico::create([
                'nombre_grado'           => $request->nombre_grado,
                'bloque'                 => $request->bloque,
                'sede_id'                => $sede->id ?? 1,
                'docente_id'             => $docente->id ?? 1,
                'estado_grado_academico' => 1,
            ]);

            return response()->json([
                'id' => $grado->id,
                'text' => $grado->nombre_grado . ' - ' . $grado->bloque,
                'message' => 'Grado académico creado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el grado académico: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $grados = GradoAcademico::all()->map(function($g) {
            return [
                'id' => $g->id,
                'text' => $g->nombre_grado . ' - ' . $g->bloque
            ];
        });
        return response()->json($grados);
    }
}
