<?php

namespace App\Http\Controllers;

use App\Models\NotasDefinitivas;
use Illuminate\Http\Request;

class NotasDefinitivasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NotasDefinitivas::query();

        // Filtros multi-parámetro
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('documento_estudiante', 'LIKE', "%$search%")
                  ->orWhere('nombre_estudiante', 'LIKE', "%$search%");
            });
        }

        if ($request->filled('grado_aprobado')) {
            $query->where('grado_aprobado', $request->grado_aprobado);
        }

        if ($request->filled('curso')) {
            $query->where('curso', $request->curso);
        }

        if ($request->filled('nombre_asignatura')) {
            $query->where('nombre_asignatura', $request->nombre_asignatura);
        }

        // Cantidad por página (defecto 80)
        $perPage = $request->get('per_page', 80);
        $notasDefinitivas = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

        // Datos para los filtros
        $grados = NotasDefinitivas::distinct()->pluck('grado_aprobado');
        $cursos = NotasDefinitivas::distinct()->pluck('curso');
        $asignaturas = NotasDefinitivas::distinct()->pluck('nombre_asignatura');

        return view('NotasDefinitivas.Index', compact('notasDefinitivas', 'grados', 'cursos', 'asignaturas'));
    }

    public function create()
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede gestionar estos registros.');

        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');
        
        return view('NotasDefinitivas.Create', compact('grados', 'cursos', 'asignaturas', 'estudiantes'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede gestionar estos registros.');

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

    public function edit(NotasDefinitivas $notasDefinitiva)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede editar registros.');

        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $cursos = \App\Models\Curso::orderBy('nombre_curso')->get();
        $asignaturas = \App\Models\Asignatura::orderBy('nombre_asignatura')->get();
        $estudiantes = \App\Models\Estudiante::with('user')->get()->sortBy('user.name');

        return view('NotasDefinitivas.Edit', [
            'notasDefinitivas' => $notasDefinitiva, 
            'grados'          => $grados, 
            'cursos'          => $cursos, 
            'asignaturas'      => $asignaturas, 
            'estudiantes'     => $estudiantes
        ]);
    }

    public function update(Request $request, NotasDefinitivas $notasDefinitiva)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede actualizar registros.');

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

        $notasDefinitiva->update($data);

        return redirect()->route('admin.notas-definitivas.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El registro histórico fue actualizado correctamente. Definitiva calculada: ' . $data['nota_definitiva']
        ]);
    }

    public function destroy(NotasDefinitivas $notasDefinitiva)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $notasDefinitiva->delete();

        return redirect()->route('admin.notas-definitivas.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El registro fue eliminado correctamente.'
        ]);
    }
}
