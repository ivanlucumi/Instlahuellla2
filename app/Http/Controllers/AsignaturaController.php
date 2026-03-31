<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para ver este listado.');

        $query = Asignatura::with(['hilo', 'grados']);
        
        // Si es DIRECTOR y no SUPERADMIN/ADMIN, solo ve asignaturas de sus grados asignados
        if (auth()->user()->hasRol('DIRECTOR') && !auth()->user()->hasRol('SUPERADMIN') && !auth()->user()->hasRol('ADMIN')) {
            $directorId = auth()->id();
            $query->whereHas('grados', function($q) use ($directorId) {
                $q->whereHas('docente', function($sq) use ($directorId) {
                    $sq->where('user_id', $directorId);
                });
            });
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('nombre_asignatura', 'LIKE', "%$search%");
        }

        if ($request->filled('hilo_id')) {
            $query->where('hilo_id', $request->hilo_id);
        }

        if ($request->filled('nivel_educativo')) {
            $query->where('nivel_educativo', $request->nivel_educativo);
        }

        $perPage = $request->get('per_page', 50);
        $asignaturas = $query->orderBy('nombre_asignatura', 'asc')->paginate($perPage)->appends($request->all());
        
        $hilos = \App\Models\Hilo::orderBy('nombre_hilo')->get();
        return view('Asignatura.Index', compact('asignaturas', 'hilos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para crear registros. Solo roles directivos pueden hacerlo.');

        $hilos = \App\Models\Hilo::where('estado', 'activo')->orderBy('nombre_hilo')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        $selectedGradoId = $request->query('grado_id');
        return view('Asignatura.Create', compact('hilos', 'grados', 'selectedGradoId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'nombre_asignatura' => 'required|string|max:255',
            'nivel_educativo'   => 'required|in:primaria,secundaria',
            'hilo_id'           => 'required|exists:hilos,id',
            'estado'            => 'required|in:activo,inactivo',
        ]);

        Asignatura::create($request->all());

        return redirect()->route('admin.asignatura.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'La asignatura fue registrada correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignatura $asignatura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignatura $asignatura)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $hilos = \App\Models\Hilo::where('estado', 'activo')->orderBy('nombre_hilo')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        return view('Asignatura.Edit', compact('asignatura', 'hilos', 'grados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'nombre_asignatura' => 'required|string|max:255',
            'nivel_educativo'   => 'required|in:primaria,secundaria',
            'hilo_id'           => 'required|exists:hilos,id',
            'estado'            => 'required|in:activo,inactivo',
        ]);

        $asignatura->update($request->all());

        return redirect()->route('admin.asignatura.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'La asignatura fue actualizada correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $asignatura->delete();

        return redirect()->route('admin.asignatura.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La asignatura fue eliminada correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'nombre_asignatura' => 'required|string|max:255',
            'nivel_educativo'   => 'required|in:primaria,secundaria',
            'hilo_id'           => 'required|exists:hilos,id',
        ]);

        try {
            $asignatura = Asignatura::create([
                'nombre_asignatura' => $request->nombre_asignatura,
                'nivel_educativo'   => $request->nivel_educativo,
                'hilo_id'           => $request->hilo_id,
                'estado'            => 'activo',
            ]);

            return response()->json([
                'id' => $asignatura->id,
                'text' => $asignatura->nombre_asignatura . ' (' . ucfirst($asignatura->nivel_educativo) . ')',
                'message' => 'Asignatura creada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la asignatura: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $asignaturas = Asignatura::with('hilo')->get()->map(function($a) {
            return [
                'id' => $a->id,
                'text' => $a->nombre_asignatura . ' (' . ($a->hilo->nombre_hilo ?? 'N/A') . ') - ' . ucfirst($a->nivel_educativo)
            ];
        });
        return response()->json($asignaturas);
    }
}
