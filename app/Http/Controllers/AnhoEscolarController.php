<?php

namespace App\Http\Controllers;

use App\Models\AnhoEscolar;
use Illuminate\Http\Request;

class AnhoEscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AnhoEscolar::query();

        if ($request->filled('search')) {
            $query->where('nombre_anho_escolar', 'LIKE', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $anhoEscolars = $query->orderBy('nombre_anho_escolar', 'desc')->paginate($perPage)->appends($request->all());

        return view('AnhoEscolar.Index', compact('anhoEscolars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AnhoEscolar.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_anho_escolar'       => 'required|string|max:255',
            'fecha_inicio_anho_escolar' => 'required|date',
            'fecha_fin_anho_escolar'    => 'required|date|after:fecha_inicio_anho_escolar',
            'descripcion_anho_escolar'  => 'required|string',
            'estado_anho_escolar'       => 'nullable|boolean',
        ]);

        AnhoEscolar::create([
            'nombre_anho_escolar'       => $request->nombre_anho_escolar,
            'fecha_inicio_anho_escolar' => $request->fecha_inicio_anho_escolar,
            'fecha_fin_anho_escolar'    => $request->fecha_fin_anho_escolar,
            'descripcion_anho_escolar'  => $request->descripcion_anho_escolar,
            'estado_anho_escolar'       => $request->has('estado_anho_escolar') ? 1 : 0,
        ]);

        return redirect()->route('admin.anhoescolar.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El año escolar fue registrado correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AnhoEscolar $anhoEscolar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnhoEscolar $anhoEscolar)
    {
        return view('AnhoEscolar.Edit', compact('anhoEscolar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnhoEscolar $anhoEscolar)
    {
        $request->validate([
            'nombre_anho_escolar'       => 'required|string|max:255',
            'fecha_inicio_anho_escolar' => 'required|date',
            'fecha_fin_anho_escolar'    => 'required|date|after:fecha_inicio_anho_escolar',
            'descripcion_anho_escolar'  => 'required|string',
            'estado_anho_escolar'       => 'nullable|boolean',
        ]);

        $anhoEscolar->update([
            'nombre_anho_escolar'       => $request->nombre_anho_escolar,
            'fecha_inicio_anho_escolar' => $request->fecha_inicio_anho_escolar,
            'fecha_fin_anho_escolar'    => $request->fecha_fin_anho_escolar,
            'descripcion_anho_escolar'  => $request->descripcion_anho_escolar,
            'estado_anho_escolar'       => $request->has('estado_anho_escolar') ? 1 : 0,
        ]);

        return redirect()->route('admin.anhoescolar.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El año escolar fue actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnhoEscolar $anhoEscolar)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $anhoEscolar->delete();
        return redirect()->route('admin.anhoescolar.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El año escolar fue eliminado correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
        $request->validate([
            'nombre_anho_escolar'       => 'required|string|max:255',
            'fecha_inicio_anho_escolar' => 'required|date',
            'fecha_fin_anho_escolar'    => 'required|date|after:fecha_inicio_anho_escolar',
        ]);

        try {
            $anho = AnhoEscolar::create([
                'nombre_anho_escolar'       => $request->nombre_anho_escolar,
                'fecha_inicio_anho_escolar' => $request->fecha_inicio_anho_escolar,
                'fecha_fin_anho_escolar'    => $request->fecha_fin_anho_escolar,
                'descripcion_anho_escolar'  => 'Creado desde matrícula rápida',
                'estado_anho_escolar'       => 1,
            ]);

            return response()->json([
                'id' => $anho->id,
                'text' => $anho->nombre_anho_escolar,
                'message' => 'Año escolar creado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el año escolar: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $anhos = AnhoEscolar::all()->map(function($a) {
            return [
                'id' => $a->id,
                'text' => $a->nombre_anho_escolar
            ];
        });
        return response()->json($anhos);
    }
}
