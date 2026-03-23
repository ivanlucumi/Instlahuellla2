<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Curso::query();

        if ($request->filled('search')) {
            $query->where('nombre_curso', 'LIKE', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 30);
        $cursos = $query->orderBy('nombre_curso', 'asc')->paginate($perPage)->appends($request->all());

        return view('Curso.Index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Curso.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'estado'       => 'required|in:activo,inactivo',
        ]);

        Curso::create($request->all());

        return redirect()->route('admin.curso.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El curso fue registrado correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('Curso.Edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'estado'       => 'required|in:activo,inactivo',
        ]);

        $curso->update($request->all());

        return redirect()->route('admin.curso.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El curso fue actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $curso->delete();

        return redirect()->route('admin.curso.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El curso fue eliminado correctamente.'
        ]);
    }
}
