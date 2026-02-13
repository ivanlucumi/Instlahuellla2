<?php

namespace App\Http\Controllers;

use App\Models\Matriculado;
use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Acudiente;
use App\Models\GradoAcademico;
use App\Models\AnhoEscolar;
use Illuminate\Http\Request;

class MatriculadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matriculados = Matriculado::with([
            'estudiante.user',
            'asignatura',
            'acudiente.user',
            'grado',
            'anhoEscolar'
        ])->orderBy('id', 'desc')->paginate(15);
        
        return view('Matriculado.Index', compact('matriculados'));
    }

    public function create()
    {
        $matriculado = new Matriculado(); // Variable vacía para el formulario
        $estudiantes = Estudiante::with('user')->orderBy('id')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre_asignatura')->get();
        $acudientes = Acudiente::with('user')->orderBy('id')->get();
        $grados = GradoAcademico::where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)->orderBy('nombre_anho_escolar', 'desc')->get();

        return view('Matriculado.Create', compact('matriculado', 'estudiantes', 'asignaturas', 'acudientes', 'grados', 'anhosEscolares'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'asignatura_id'    => 'required|exists:asignaturas,id',
            'acudiente_id'     => 'required|exists:acudientes,id',
            'grado_id'         => 'required|exists:grado_academicos,id',
            'anho_escolar_id'  => 'required|exists:anho_escolar,id',
            'estado'           => 'required|in:activo,inactivo,retirado',
            'fecha_matricula'  => 'required|date',
            'observaciones'    => 'nullable|string',
        ]);

        // Validar que no exista una matrícula duplicada
        $existe = Matriculado::where('estudiante_id', $request->estudiante_id)
            ->where('asignatura_id', $request->asignatura_id)
            ->where('anho_escolar_id', $request->anho_escolar_id)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'estudiante_id' => 'Este estudiante ya está matriculado en esta asignatura para el año escolar seleccionado.'
            ])->withInput();
        }

        Matriculado::create($request->all());

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El estudiante fue matriculado correctamente.'
        ]);
    }

    public function show(Matriculado $matriculado)
    {
        //
    }

    public function edit(Matriculado $matriculado)
    {
        $estudiantes = Estudiante::with('user')->orderBy('id')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre_asignatura')->get();
        $acudientes = Acudiente::with('user')->orderBy('id')->get();
        $grados = GradoAcademico::where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)->orderBy('nombre_anho_escolar', 'desc')->get();

        return view('Matriculado.Edit', compact('matriculado', 'estudiantes', 'asignaturas', 'acudientes', 'grados', 'anhosEscolares'));
    }

    public function update(Request $request, Matriculado $matriculado)
    {
        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'asignatura_id'    => 'required|exists:asignaturas,id',
            'acudiente_id'     => 'required|exists:acudientes,id',
            'grado_id'         => 'required|exists:grado_academicos,id',
            'anho_escolar_id'  => 'required|exists:anho_escolar,id',
            'estado'           => 'required|in:activo,inactivo,retirado',
            'fecha_matricula'  => 'required|date',
            'observaciones'    => 'nullable|string',
        ]);

        // Validar que no exista una matrícula duplicada (excluyendo la actual)
        $existe = Matriculado::where('estudiante_id', $request->estudiante_id)
            ->where('asignatura_id', $request->asignatura_id)
            ->where('anho_escolar_id', $request->anho_escolar_id)
            ->where('id', '!=', $matriculado->id)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'estudiante_id' => 'Este estudiante ya está matriculado en esta asignatura para el año escolar seleccionado.'
            ])->withInput();
        }

        $matriculado->update($request->all());

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'La matrícula fue actualizada correctamente.'
        ]);
    }

    public function destroy(Matriculado $matriculado)
    {
        $matriculado->delete();

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La matrícula fue eliminada correctamente.'
        ]);
    }
}
