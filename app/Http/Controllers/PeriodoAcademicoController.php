<?php

namespace App\Http\Controllers;

use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class PeriodoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodos = PeriodoAcademico::with('anhoEscolar')->orderBy('id', 'desc')->paginate(15);
        return view('PeriodoAcademico.Index', compact('periodos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anhos = \App\Models\AnhoEscolar::where('estado_anho_escolar', 1)->get();
        return view('PeriodoAcademico.Create', compact('anhos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'año_escolar_id'     => 'required|exists:anho_escolar,id',
            'nombre_periodo'     => 'required|string|max:255',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'required|date|after:fecha_inicio',
            'porcentaje_periodo' => 'required|numeric|min:0|max:100',
            'estado'             => 'required|in:activo,inactivo',
        ]);

        PeriodoAcademico::create($request->all());

        return redirect()->route('admin.periodoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El periodo académico fue registrado correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodoAcademico $periodoAcademico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeriodoAcademico $periodoAcademico)
    {
        $anhos = \App\Models\AnhoEscolar::where('estado_anho_escolar', 1)->get();
        return view('PeriodoAcademico.Edit', compact('periodoAcademico', 'anhos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeriodoAcademico $periodoAcademico)
    {
        $request->validate([
            'año_escolar_id'     => 'required|exists:anho_escolar,id',
            'nombre_periodo'     => 'required|string|max:255',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'required|date|after:fecha_inicio',
            'porcentaje_periodo' => 'required|numeric|min:0|max:100',
            'estado'             => 'required|in:activo,inactivo',
        ]);

        $periodoAcademico->update($request->all());

        return redirect()->route('admin.periodoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El periodo académico fue actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeriodoAcademico $periodoAcademico)
    {
        $periodoAcademico->delete();
        return redirect()->route('admin.periodoacademico.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El periodo académico fue eliminado correctamente.'
        ]);
    }
}
