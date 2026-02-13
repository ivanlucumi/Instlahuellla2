<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\GradoAcademico;
use App\Models\Matriculado;
use App\Models\Notas;
use Illuminate\Http\Request;

class DocenteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::with('user')->orderBy('id')->get();
        return view('Docente.Index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('Docente.Create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔒 Validación
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'codigo_docente'  => 'required|string|unique:docentes,codigo_docente',
            'genero_docente'  => 'required|string',
            'foto_docente'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado_docente'  => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request) {
            // 1. Crear Usuario
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => \Hash::make('Temporal123'),
                'genero'   => $request->genero_docente, // Usamos el mismo género
            ]);

            // 2. Asignar Rol DOCENTE
            $rolDocente = \App\Models\Rol::where('nombre', 'DOCENTE')->first();
            if ($rolDocente) {
                $user->roles()->attach($rolDocente->id);
            }

            // 3. Manejo de foto
            $fotoPath = null;
            if ($request->hasFile('foto_docente')) {
                $fotoPath = $request->file('foto_docente')->store('docentes', 'public');
            }

            // 4. Crear Docente
            Docente::create([
                'user_id'        => $user->id,
                'codigo_docente' => $request->codigo_docente,
                'genero_docente' => $request->genero_docente,
                'foto_docente'   => $fotoPath ?? 'default.png',
                'estado_docente' => $request->has('estado_docente') ? true : false,
            ]);
        });

        // ✅ Éxito
        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El docente y su usuario fueron registrados correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        // No necesitamos lista de usuarios, ya editamos el propio
        return view('Docente.Edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        // 🔒 Validación
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $docente->user_id,
            'password'        => 'nullable|string|min:8',
            'codigo_docente'  => 'required|string|unique:docentes,codigo_docente,' . $docente->id,
            'genero_docente'  => 'required|string',
            'foto_docente'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado_docente'  => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request, $docente) {
            // 1. Actualizar Usuario
            $userData = [
                'name'   => $request->name,
                'email'  => $request->email,
                'genero' => $request->genero_docente,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = \Hash::make($request->password);
            }
            
            $docente->user->update($userData);

            // 2. Manejo de foto
            $fotoPath = $docente->foto_docente;
            if ($request->hasFile('foto_docente')) {
                if ($docente->foto_docente && $docente->foto_docente !== 'default.png') {
                    \Storage::disk('public')->delete($docente->foto_docente);
                }
                $fotoPath = $request->file('foto_docente')->store('docentes', 'public');
            }

            // 3. Actualizar Docente
            $docente->update([
                'codigo_docente' => $request->codigo_docente,
                'genero_docente' => $request->genero_docente,
                'foto_docente'   => $fotoPath,
                'estado_docente' => $request->has('estado_docente') ? true : false,
            ]);
        });

        // ✅ Éxito
        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El docente y su usuario de acceso fueron actualizados correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        // Eliminar foto si existe y no es la default
        if ($docente->foto_docente && $docente->foto_docente !== 'default.png') {
            \Storage::disk('public')->delete($docente->foto_docente);
        }

        $docente->delete();

        return redirect()->route('admin.docente.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El docente fue eliminado correctamente.'
        ]);
    }


    public function asignaturaDocente()
    {
        $docente = auth()->user();

        $asignaturas = $docente->asignaturas()->get();

       //dd($asignaturas);

        return view('Docente.asignatura.asignatura_docente', compact('asignaturas'));
    }

    public function asignatura_grado_docente()
    {
        $docente = auth()->user();

        $asignaturas = $docente->asignaturas;
        $grados = auth()->user()->docente?->grados;
        //dd($grado, $asignaturas);
        return view('Docente.grado.grado_docente', compact('asignaturas', 'grados'));
    }


    public function listadoClases($gradoId)
    {
        $grado = GradoAcademico::with('asignatura')
                ->findOrFail($gradoId);

    $estudiantes = Matriculado::with('estudiante.user')
        ->where('grado_id', $gradoId)
        ->get();

    return view('Docente.grado.listado_clases', compact('grado', 'estudiantes'));
    }

    public function listaCalificarEstudiante()
    {
        
        $docente = auth()->user();

        $asignaturas = $docente->asignaturas;
        $grados = auth()->user()->docente?->grados;
        //dd($asignaturas, $grados);
        return view('Docente.grado.lista_calificar', compact('asignaturas', 'grados'));
    }
    
    public function calificarEstudianteFinal($gradoId)
    {
        $grado = GradoAcademico::with('asignatura')
                ->findOrFail($gradoId);

    $estudiantes = Matriculado::with('estudiante.user')
        ->where('grado_id', $gradoId)
        ->get();

    return view('Docente.grado.calificar', compact('grado', 'estudiantes'));
    }

    public function guardarNotas(Request $request)
    {
        $request->validate([
            'notas.*.nota' => 'required|numeric|min:0|max:5',
            'notas.*.observaciones' => 'nullable|string|max:500'
        ]);

        foreach ($request->notas as $estudianteId => $data) {

            Notas::updateOrCreate(
                [
                    'periodo_academico_id' => $request->periodo_academico_id,
                    'grado_id'             => $request->grado_id,
                    'estudiante_id'        => $estudianteId,
                    'asignatura_id'        => $request->asignatura_id,
                ],
                [
                    'nota'          => $data['nota'],
                    'observaciones' => $data['observaciones'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Notas guardadas correctamente');
    }



}

