<?php

namespace App\Http\Controllers;

use App\Models\CriterioGradoCero;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class CriterioGradoCeroController extends Controller
{
    public function index()
    {
        $criterios = CriterioGradoCero::with('asignatura')->orderBy('asignatura_id')->paginate(50);
        return view('GradoCero.Criterios.index', compact('criterios'));
    }

    public function create()
    {
        $asignaturas = Asignatura::whereHas('hilo', function($q) {
            $q->where('nombre_hilo', 'LIKE', '%CERO%')
              ->orWhere('nombre_hilo', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_hilo', 'LIKE', '%DIMENSION%');
        })->orWhereHas('grados', function($q) {
            $q->where('nombre_grado', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_grado', 'LIKE', '%CERO%');
        })->orderBy('nombre_asignatura')->get();
        
        return view('GradoCero.Criterios.create', compact('asignaturas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'criterios' => 'required|array|min:1',
            'criterios.*' => 'required|string|max:255',
            'estado' => 'boolean',
        ]);

        foreach ($request->criterios as $nombre) {
            if ($nombre) {
                CriterioGradoCero::create([
                    'asignatura_id' => $request->asignatura_id,
                    'nombre_criterio' => $nombre,
                    'estado' => $request->estado ?? 1,
                ]);
            }
        }

        return redirect()->route('admin.grado-cero.criterios.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Los criterios han sido creados correctamente.'
        ]);
    }

    public function edit(CriterioGradoCero $criterio)
    {
        $asignaturas = Asignatura::whereHas('hilo', function($q) {
            $q->where('nombre_hilo', 'LIKE', '%CERO%')
              ->orWhere('nombre_hilo', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_hilo', 'LIKE', '%DIMENSION%');
        })->orWhereHas('grados', function($q) {
            $q->where('nombre_grado', 'LIKE', '%TRANSICION%')
              ->orWhere('nombre_grado', 'LIKE', '%CERO%');
        })->orderBy('nombre_asignatura')->get();
        
        return view('GradoCero.Criterios.edit', compact('criterio', 'asignaturas'));
    }

    public function update(Request $request, CriterioGradoCero $criterio)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'nombre_criterio' => 'required|string|max:255',
            'estado' => 'boolean',
        ]);

        $criterio->update($request->all());

        return redirect()->route('admin.grado-cero.criterios.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El criterio ha sido actualizado correctamente.'
        ]);
    }

    public function destroy(CriterioGradoCero $criterio)
    {
        $criterio->delete();
        return redirect()->route('admin.grado-cero.criterios.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'El criterio ha sido eliminado.'
        ]);
    }
}
