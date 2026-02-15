<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\GradoAcademico;
use App\Models\Matriculado;
use App\Models\Notas;
use App\Models\Asignatura;
use App\Models\Estudiante;
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
        $user = auth()->user();
        
        // Obtenemos todos los grados donde este docente dicta alguna materia
        $gradosConMaterias = GradoAcademico::whereHas('asignaturas', function($q) use ($user) {
            $q->where('asignatura_grado_docente.docente_id', $user->id);
        })->with(['asignaturas' => function($q) use ($user) {
            $q->where('asignatura_grado_docente.docente_id', $user->id)->with('hilo');
        }])->get();

        // Aplanamos para la vista
        $assignments = collect();
        foreach ($gradosConMaterias as $grado) {
            foreach ($grado->asignaturas as $asig) {
                $assignments->push((object)[
                    'id'                => $asig->id,
                    'nombre_asignatura' => $asig->nombre_asignatura,
                    'hilo_nombre'       => $asig->hilo->nombre_hilo ?? 'N/A',
                    'grado_id'          => $grado->id,
                    'grado_nombre'      => $grado->nombre_grado . ' - ' . $grado->bloque,
                ]);
            }
        }

        return view('Docente.asignatura.asignatura_docente', compact('assignments'));
    }

    public function estudiantesAsignatura($asignaturaId, $gradoId)
    {
        $asignatura = Asignatura::with(['hilo', 'sede'])->findOrFail($asignaturaId);
        $grado = GradoAcademico::findOrFail($gradoId);
        
        $estudiantes = Estudiante::with(['user', 'notas' => function($query) use ($asignaturaId, $gradoId) {
            $query->where('asignatura_id', $asignaturaId)->where('grado_id', $gradoId);
        }])
        ->where('grado_academico_id', $gradoId)
        ->get();

        $all_graded = $estudiantes->isNotEmpty();
        foreach ($estudiantes as $estudiante) {
            $nota = $estudiante->notas->first();
            if (!$nota || $nota->nota_definitiva === null || $nota->nota_definitiva == 0) {
                $all_graded = false;
                break;
            }
        }

        $todosLosGrados = GradoAcademico::all();

        return view('Docente.asignatura.estudiantes_asignatura', compact('asignatura', 'grado', 'estudiantes', 'todosLosGrados', 'all_graded'));
    }

    public function updateNotas(Request $request)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id'      => 'required|exists:grado_academicos,id',
            'notas'         => 'required|array',
        ]);

        $errors = [];
        $savedCount = 0;

        foreach ($request->notas as $estudianteId => $notasData) {
            $nota1 = $notasData['nota1'] ?? null;
            $nota2 = $notasData['nota2'] ?? null;
            $nota3 = $notasData['nota3'] ?? null;
            $nota4 = $notasData['nota4'] ?? null;
            $observaciones = $notasData['observaciones'] ?? null;

            if ($nota1 === null && $nota2 === null && $nota3 === null && $nota4 === null) {
                continue;
            }

            if (empty($observaciones)) {
                $estudiante = Estudiante::find($estudianteId);
                $nombre = $estudiante ? $estudiante->user->name : "ID: $estudianteId";
                $errors[] = "Las observaciones son obligatorias para el estudiante $nombre.";
                continue;
            }

            $estudiante = Estudiante::findOrFail($estudianteId);
            
            // Auto-matriculación si no existe
            $matricula = Matriculado::firstOrCreate(
                [
                    'estudiante_id' => $estudianteId,
                    'grado_id' => $request->grado_id
                ],
                [
                    'acudiente_id' => $estudiante->acudiente_id ?? 1, // Fallback a ID 1 si no hay acudiente
                    'fecha_matricula' => now(),
                    'estado_matricula' => 'activo'
                ]
            );

            $notas = [$nota1, $nota2, $nota3, $nota4];
            $validNotas = array_filter($notas, fn($n) => $n !== null && $n !== '');
            $definitiva = count($validNotas) > 0 ? array_sum($validNotas) / count($validNotas) : 0;

            Notas::updateOrCreate(
                [
                    'matriculado_id' => $matricula->id,
                    'asignatura_id' => $request->asignatura_id,
                ],
                [
                    'estudiante_id' => $estudianteId,
                    'grado_id' => $request->grado_id,
                    'nota1' => $nota1,
                    'nota2' => $nota2,
                    'nota3' => $nota3,
                    'nota4' => $nota4,
                    'nota_definitiva' => $definitiva,
                    'observaciones' => $observaciones,
                ]
            );
            $savedCount++;
        }

        if (count($errors) > 0) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Atención',
                'text' => implode('\n', $errors)
            ])->withErrors($errors);
        }

        if ($savedCount === 0) {
            return back()->with('swal', [
                'icon' => 'info',
                'title' => 'Sin cambios',
                'text' => 'No se ingresaron notas para guardar.'
            ]);
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Las calificaciones han sido actualizadas.'
        ]);
    }

    public function promoverEstudiantes(Request $request)
    {
        $request->validate([
            'estudiantes' => 'required|array',
            'grado_destino_id' => 'required|exists:grado_academicos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);

        $errors = [];
        $promotedCount = 0;
        $gradoDestino = GradoAcademico::findOrFail($request->grado_destino_id);

        foreach ($request->estudiantes as $estudianteId) {
            $estudiante = Estudiante::findOrFail($estudianteId);
            
            // Validar que sea un grado "superior" (ID mayor, lógica simple por ahora)
            if ($gradoDestino->id <= $estudiante->grado_academico_id) {
                $errors[] = "El estudiante {$estudiante->user->name} solo puede ser promovido a un grado superior.";
                continue;
            }

            $nota = Notas::where('estudiante_id', $estudianteId)
                ->where('asignatura_id', $request->asignatura_id)
                ->where('grado_id', $estudiante->grado_academico_id)
                ->first();

            if (!$nota || $nota->nota_definitiva < 3) {
                $defVal = $nota ? $nota->nota_definitiva : 'N/A';
                $errors[] = "{$estudiante->user->name} no cumple el requisito (Nota: $defVal).";
                continue;
            }

            // Actualizar estudiante
            $estudiante->update([
                'grado_academico_id' => $request->grado_destino_id
            ]);

            // Crear nueva matrícula para el nuevo grado
            Matriculado::updateOrCreate(
                [
                    'estudiante_id' => $estudianteId,
                    'grado_id' => $request->grado_destino_id
                ],
                [
                    'fecha_matricula' => now(),
                    'estado_matricula' => 'activo',
                    'acudiente_id' => $estudiante->acudiente_id ?? 1
                ]
            );

            $promotedCount++;
        }

        if (count($errors) > 0) {
            return back()->with('swal', [
                'icon' => $promotedCount > 0 ? 'warning' : 'error',
                'title' => $promotedCount > 0 ? 'Promoción Parcial' : 'Error',
                'text' => implode('\n', $errors)
            ]);
        }

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => "Se han promovido $promotedCount estudiantes y se han generado sus nuevas matrículas."
        ]);
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

