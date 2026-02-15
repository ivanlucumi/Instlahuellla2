<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignaturas = Asignatura::with(['hilo', 'grados'])->orderBy('id')->paginate(15);
        return view('Asignatura.Index', compact('asignaturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
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
        $hilos = \App\Models\Hilo::where('estado', 'activo')->orderBy('nombre_hilo')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        return view('Asignatura.Edit', compact('asignatura', 'hilos', 'grados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
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
        $asignatura->delete();

        return redirect()->route('admin.asignatura.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La asignatura fue eliminada correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
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
