<?php

namespace App\Http\Controllers;

use App\Models\NotasDefinitivas;
use Illuminate\Http\Request;

class NotasDefinitivasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notasDefinitivas = NotasDefinitivas::orderBy('id')->paginate(15);
        return view('NotasDefinitivas.Index', compact('notasDefinitivas'));
    }

    public function create()
    {
        // Aunque guardamos texto, necesitamos los datos para que el usuario seleccione
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');
        
        return view('NotasDefinitivas.Create', compact('grados', 'cursos', 'asignaturas', 'estudiantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento_estudiante' => 'required|string|max:20',
            'nombre_estudiante'    => 'required|string|max:255',
            'grado_aprobado'       => 'required|string|max:100',
            'nota_per1'            => 'required|numeric|min:0|max:5',
            'nota_per2'            => 'required|numeric|min:0|max:5',
            'nota_per3'            => 'required|numeric|min:0|max:5',
            'nota_per4'            => 'nullable|numeric|min:0|max:5',
            'nombre_asignatura'    => 'required|string|max:255',
            'curso'                => 'required|string|max:100',
        ]);

        $n1 = $request->nota_per1;
        $n2 = $request->nota_per2;
        $n3 = $request->nota_per3;
        $n4 = $request->filled('nota_per4') ? $request->nota_per4 : null;

        if ($n4 !== null && $n4 > 0) {
            $definitiva = ($n1 + $n2 + $n3 + $n4) / 4;
        } else {
            $definitiva = ($n1 + $n2 + $n3) / 3;
            $n4 = 0; // Guardamos 0 en BD si es nulo
        }

        $data = $request->all();
        $data['nota_per4'] = $n4;
        $data['nota_definitiva'] = number_format($definitiva, 2, '.', '');

        NotasDefinitivas::create($data);

        return redirect()->route('admin.notas-definitivas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El registro histórico fue guardado correctamente. Definitiva calculada: ' . $data['nota_definitiva']
        ]);
    }

    public function show(NotasDefinitivas $notasDefinitivas)
    {
        //
    }

    public function edit(NotasDefinitivas $notasDefinitivas)
    {
        // Para editar, pasamos los valores actuales. 
        // Si se requiere que siga siendo texto libre o seleccionable, podemos pasar las listas también.
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');

        return view('NotasDefinitivas.Edit', compact('notasDefinitivas', 'grados', 'cursos', 'asignaturas', 'estudiantes'));
    }

    public function update(Request $request, NotasDefinitivas $notasDefinitivas)
    {
        $request->validate([
            'documento_estudiante' => 'required|string|max:20',
            'nombre_estudiante'    => 'required|string|max:255',
            'grado_aprobado'       => 'required|string|max:100',
            'nota_per1'            => 'required|numeric|min:0|max:5',
            'nota_per2'            => 'required|numeric|min:0|max:5',
            'nota_per3'            => 'required|numeric|min:0|max:5',
            'nota_per4'            => 'nullable|numeric|min:0|max:5',
            'nombre_asignatura'    => 'required|string|max:255',
            'curso'                => 'required|string|max:100',
        ]);

        $n1 = $request->nota_per1;
        $n2 = $request->nota_per2;
        $n3 = $request->nota_per3;
        $n4 = $request->filled('nota_per4') ? $request->nota_per4 : null;

        if ($n4 !== null && $n4 > 0) {
            $definitiva = ($n1 + $n2 + $n3 + $n4) / 4;
        } else {
            $definitiva = ($n1 + $n2 + $n3) / 3;
            $n4 = 0;
        }

        $data = $request->all();
        $data['nota_per4'] = $n4;
        $data['nota_definitiva'] = number_format($definitiva, 2, '.', '');

        $notasDefinitivas->update($data);

        return redirect()->route('admin.notas-definitivas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El registro histórico fue actualizado correctamente. Definitiva calculada: ' . $data['nota_definitiva']
        ]);
    }

    public function destroy(NotasDefinitivas $notasDefinitivas)
    {
        $notasDefinitivas->delete();

        return redirect()->route('admin.notas-definitivas.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El registro fue eliminado correctamente.'
        ]);
    }
}
