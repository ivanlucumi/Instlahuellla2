<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Matriculado;
use App\Models\Notas;
use App\Models\AnhoEscolar;
use App\Models\Acudiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $isDirector = $user->hasRol('DIRECTOR') && !$user->hasRol('SUPERADMIN') && !$user->hasRol('ADMIN');
        $misGradosIds = $isDirector ? $user->grados->pluck('id')->toArray() : [];

        // 1. Contexto de Filtros
        $anhos = \App\Models\AnhoEscolar::orderBy('nombre_anho_escolar', 'desc')->get();
        
        $gradosQuery = \App\Models\GradoAcademico::orderBy('nombre_grado');
        if ($isDirector) {
            $gradosQuery->whereIn('id', $misGradosIds);
        }
        $grados = $gradosQuery->get();

        $cursosQuery = \App\Models\MatriculaFinal::distinct();
        if ($isDirector) {
            $cursosQuery->whereIn('id_grado', $misGradosIds);
        }
        $cursos = $cursosQuery->pluck('curso');

        $asignaturasQuery = \App\Models\Asignatura::orderBy('nombre_asignatura');
        if ($isDirector) {
            $asignaturasQuery->whereHas('grados', function($q) use ($misGradosIds) {
                $q->whereIn('grado_academicos.id', $misGradosIds);
            });
        }
        $asignaturas = $asignaturasQuery->get();

        // 2. Determinar Año Lectivo Actual/Seleccionado
        $selectedAnhoId = $request->get('anho_escolar_id');
        $currentAnho = $selectedAnhoId 
            ? $anhos->find($selectedAnhoId) 
            : $anhos->where('estado_anho_escolar', 1)->first() ?? $anhos->first();
        
        $anoLectivo = $currentAnho ? $currentAnho->nombre_anho_escolar : date('Y');

        // 3. Consulta de Estudiantes con Filtros
        $query = Estudiante::query()->with([
            'user', 
            'acudiente.user', 
            'gradoAcademico',
            'matriculasFinales' => function($q) use ($anoLectivo) {
                $q->where('ano_lectivo', $anoLectivo)->with('notasDefinitivas');
            }
        ]);

        // Si es DIRECTOR, solo ve los estudiantes de sus grados asignados (Director de Grupo)
        if ($isDirector) {
            $query->whereHas('matriculasFinales', function($q) use ($misGradosIds, $anoLectivo) {
                $q->whereIn('id_grado', $misGradosIds)->where('ano_lectivo', $anoLectivo);
            });
        }

        // Filtro por Grado
        if ($request->filled('grado_id')) {
            $query->whereHas('matriculasFinales', function($q) use ($request, $anoLectivo) {
                $q->where('id_grado', $request->grado_id)->where('ano_lectivo', $anoLectivo);
            });
        }

        // Filtro por Curso (Bloque)
        if ($request->filled('curso')) {
            $query->whereHas('matriculasFinales', function($q) use ($request, $anoLectivo) {
                $q->where('curso', $request->curso)->where('ano_lectivo', $anoLectivo);
            });
        }

        // Filtro por Asignatura
        if ($request->filled('asignatura_id')) {
            $query->whereHas('matriculasFinales', function($q) use ($request, $anoLectivo) {
                $q->where('ano_lectivo', $anoLectivo)
                  ->whereHas('notasDefinitivas', function($sq) use ($request) {
                      $sq->where('asignatura_id', $request->asignatura_id);
                  });
            });
        }

        // Búsqueda General (Nombre/ID)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_identificacion_estudiante', 'like', "%{$search}%")
                  ->orWhere('codigo_estudiante', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->get('per_page', 10);
        $estudiantes = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());
        
        return view('Estudiante.Index', compact(
            'estudiantes', 
            'currentAnho', 
            'anhos', 
            'grados', 
            'cursos', 
            'asignaturas',
            'selectedAnhoId'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para crear registros. Solo roles directivos pueden hacerlo.');

        $usuarios = \App\Models\User::whereDoesntHave('estudiante')->whereDoesntHave('docente')->orderBy('name')->get();
        $acudientes = \App\Models\Acudiente::with('user')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        return view('Estudiante.Create', compact('usuarios', 'acudientes', 'grados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'name'                           => 'required|string|max:255',
            'email'                          => 'required|string|email|max:255|unique:users',
            'codigo_estudiante'              => 'required|string|unique:estudiantes,codigo_estudiante',
            'fecha_nacimiento_estudiante'    => 'required|date',
            'genero_estudiante'              => 'required|string',
            'foto_estudiante'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anho_curso_estudiante'          => 'required|string',
            'direccion_estudiante'           => 'required|string',
            'telefono_estudiante'            => 'required|string',
            'email_estudiante'               => 'required|email|unique:estudiantes,email_estudiante',
            'tipo_identificacion_estudiante' => 'required|string',
            'numero_identificacion_estudiante' => 'required|string|unique:estudiantes,numero_identificacion_estudiante',
            'acudiente_id'                   => 'required|exists:acudientes,id',
            'grado_academico_id'             => 'required|exists:grado_academicos,id',
            'estado_estudiante'              => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request) {
            // 1. Crear Usuario
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => \Hash::make('Temporal123'),
                'genero'   => $request->genero_estudiante,
            ]);

            // 2. Asignar Rol ESTUDIANTE
            $rolEstudiante = \App\Models\Rol::where('nombre', 'ESTUDIANTE')->first();
            if ($rolEstudiante) {
                $user->roles()->attach($rolEstudiante->id);
            }

            // 3. Foto
            $fotoPath = 'images/default_user.png';
            if ($request->hasFile('foto_estudiante')) {
                $imageName = time().'.'.$request->foto_estudiante->extension();
                $request->foto_estudiante->move(public_path('images/estudiantes'), $imageName);
                $fotoPath = 'images/estudiantes/'.$imageName;
            }

            // 4. Crear Estudiante
            $data = $request->except(['name', 'email', 'password', 'foto_estudiante', 'estado_estudiante']);
            $data['user_id'] = $user->id;
            $data['foto_estudiante'] = $fotoPath;
            $data['estado_estudiante'] = $request->has('estado_estudiante') ? 1 : 0;
            
            Estudiante::create($data);
        });

        return redirect()->route('admin.estudiante.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El estudiante y su usuario fueron registrados correctamente.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $acudientes = \App\Models\Acudiente::with('user')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        return view('Estudiante.Edit', compact('estudiante', 'acudientes', 'grados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'name'                           => 'required|string|max:255',
            'email'                          => 'required|string|email|max:255|unique:users,email,' . $estudiante->user_id,
            'password'                       => 'nullable|string|min:8',
            'codigo_estudiante'              => 'required|string|unique:estudiantes,codigo_estudiante,'.$estudiante->id,
            'fecha_nacimiento_estudiante'    => 'required|date',
            'genero_estudiante'              => 'required|string',
            'foto_estudiante'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anho_curso_estudiante'          => 'required|string',
            'direccion_estudiante'           => 'required|string',
            'telefono_estudiante'            => 'required|string',
            'email_estudiante'               => 'required|email|unique:estudiantes,email_estudiante,'.$estudiante->id,
            'tipo_identificacion_estudiante' => 'required|string',
            'numero_identificacion_estudiante' => 'required|string|unique:estudiantes,numero_identificacion_estudiante,'.$estudiante->id,
            'acudiente_id'                   => 'required|exists:acudientes,id',
            'grado_academico_id'             => 'required|exists:grado_academicos,id',
            'estado_estudiante'              => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request, $estudiante) {
            // 1. Actualizar Usuario
            $userData = [
                'name'   => $request->name,
                'email'  => $request->email,
                'genero' => $request->genero_estudiante,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = \Hash::make($request->password);
            }
            
            $estudiante->user->update($userData);

            // 2. Foto
            $data = $request->except(['name', 'email', 'password', 'foto_estudiante', 'estado_estudiante']);
            
            if ($request->hasFile('foto_estudiante')) {
                if ($estudiante->foto_estudiante != 'images/default_user.png' && file_exists(public_path($estudiante->foto_estudiante))) {
                    unlink(public_path($estudiante->foto_estudiante));
                }
                $imageName = time().'.'.$request->foto_estudiante->extension();
                $request->foto_estudiante->move(public_path('images/estudiantes'), $imageName);
                $data['foto_estudiante'] = 'images/estudiantes/'.$imageName;
            }

            $data['estado_estudiante'] = $request->has('estado_estudiante') ? 1 : 0;
            $estudiante->update($data);
        });

        return redirect()->route('admin.estudiante.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El estudiante y su usuario de acceso fueron actualizados correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        if ($estudiante->foto_estudiante != 'images/default_user.png' && file_exists(public_path($estudiante->foto_estudiante))) {
            unlink(public_path($estudiante->foto_estudiante));
        }
        $estudiante->delete();
        return redirect()->route('admin.estudiante.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El estudiante fue eliminado correctamente.'
        ]);
    }


    // --- STUDENT ROLE METHODS ---

    public function dashboard()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return redirect()->route('home')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No tienes un perfil de estudiante vinculado.'
            ]);
        }

        // Obtener última matrícula (año actual)
        $ultimaMatricula = Matriculado::with(['anhoEscolar', 'grado', 'acudiente.user'])
            ->where('estudiante_id', $estudiante->id)
            ->orderBy('id', 'desc')
            ->first();

        // Obtener notas del año/grado actual
        $notasActuales = collect();
        if ($ultimaMatricula) {
            $notasActuales = Notas::with('asignatura')
                ->where('estudiante_id', $estudiante->id)
                ->where('grado_id', $ultimaMatricula->grado_id)
                ->get();
        }

        $institucion = \App\Models\Institucion::first();

        return view('estudiante.dashboard', compact('estudiante', 'ultimaMatricula', 'notasActuales', 'institucion'));
    }

    public function history()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) return redirect()->route('home');

        $matriculas = Matriculado::with(['anhoEscolar', 'grado', 'acudiente.user'])
            ->where('estudiante_id', $estudiante->id)
            ->orderBy('id', 'desc')
            ->get();

        // Cargar notas para cada matrícula
        foreach ($matriculas as $matricula) {
            $matricula->notas = Notas::with('asignatura')
                ->where('estudiante_id', $estudiante->id)
                ->where('grado_id', $matricula->grado_id)
                ->get();
        }

        return view('estudiante.history', compact('estudiante', 'matriculas'));
    }

    public function editAcudiente()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        if (!$estudiante) return redirect()->route('home');

        $acudiente = $estudiante->acudiente;

        if (!$acudiente) {
            return redirect()->route('estudiante.dashboard')->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin Acudiente',
                'text' => 'No tienes un acudiente asignado en tu perfil. Por favor, contacta a la administración.'
            ]);
        }

        return view('estudiante.edit_acudiente', compact('estudiante', 'acudiente'));
    }

    public function updateAcudiente(Request $request)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        if (!$estudiante) return redirect()->route('home');

        $acudiente = $estudiante->acudiente;

        if (!$acudiente) {
            return redirect()->route('estudiante.dashboard')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se encontró el registro de tu acudiente para actualizar.'
            ]);
        }

        $request->validate([
            'celular_acudiente'   => 'required|string|max:20',
            'direccion_acudiente' => 'required|string|max:255',
            'genero_acudiente'    => 'required|string',
            'parentesco_acudiente'=> 'required|string',
        ]);

        $acudiente->update($request->all());

        return redirect()->route('estudiante.dashboard')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Actualizado!',
            'text'  => 'La información de tu acudiente ha sido actualizada correctamente.'
        ]);
    }

    public function notasPeriodo(){
         return view('estudiante.estudiante');
    }

    // --- END STUDENT ROLE METHODS ---

    public function storeQuick(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']), 403, 'No tiene permisos para modificar estos datos.');

        $request->validate([
            'name'                           => 'required|string|max:255',
            'email'                          => 'required|string|email|max:255|unique:users',
            'codigo_estudiante'              => 'required|string|unique:estudiantes,codigo_estudiante',
            'acudiente_id'                   => 'required|exists:acudientes,id',
            'grado_academico_id'             => 'required|exists:grado_academicos,id',
            'genero_estudiante'              => 'required|string',
        ]);

        try {
            return \DB::transaction(function() use ($request) {
                // 1. Crear Usuario
                $user = \App\Models\User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => \Hash::make('Temporal123'),
                    'genero'   => $request->genero_estudiante,
                ]);

                // 2. Asignar Rol ESTUDIANTE
                $rolEstudiante = \App\Models\Rol::where('nombre', 'ESTUDIANTE')->first();
                if ($rolEstudiante) {
                    $user->roles()->attach($rolEstudiante->id);
                }

                // 3. Crear Estudiante
                $estudiante = Estudiante::create([
                    'user_id' => $user->id,
                    'codigo_estudiante' => $request->codigo_estudiante,
                    'acudiente_id' => $request->acudiente_id,
                    'grado_academico_id' => $request->grado_academico_id,
                    'fecha_nacimiento_estudiante' => $request->fecha_nacimiento_estudiante ?? date('Y-m-d'),
                    'genero_estudiante' => $request->genero_estudiante,
                    'anho_curso_estudiante' => date('Y'),
                    'direccion_estudiante' => 'N/A',
                    'telefono_estudiante' => 'N/A',
                    'email_estudiante' => $request->email,
                    'tipo_identificacion_estudiante' => 'TI',
                    'numero_identificacion_estudiante' => $request->codigo_estudiante,
                    'estado_estudiante' => 1,
                    'foto_estudiante' => 'images/default_user.png',
                ]);

                return response()->json([
                    'id' => $estudiante->id,
                    'text' => $user->name . ' (' . $estudiante->codigo_estudiante . ')',
                    'message' => 'Estudiante creado exitosamente'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el estudiante: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $estudiantes = Estudiante::with('user')->get()->map(function($e) {
            return [
                'id' => $e->id,
                'text' => ($e->user->name ?? 'Sin nombre') . ' (' . $e->codigo_estudiante . ')'
            ];
        });
        return response()->json($estudiantes);
    }

    public function buscarPorDocumento(Request $request)
    {
        $documento = $request->query('documento');
        
        if (!$documento) {
            return response()->json(['encontrado' => false], 400);
        }

        $estudiante = Estudiante::with('user')->where('numero_identificacion_estudiante', $documento)->first();

        if ($estudiante) {
            return response()->json([
                'encontrado'         => true,
                'name'               => $estudiante->user->name ?? '',
                'email'              => $estudiante->user->email ?? '',
                'genero_estudiante'  => $estudiante->genero_estudiante ?? '',
                'telefono_estudiante' => $estudiante->telefono_estudiante ?? '',
                'direccion_estudiante' => $estudiante->direccion_estudiante ?? '',
                'fecha_nacimiento'   => $estudiante->fecha_nacimiento_estudiante ? $estudiante->fecha_nacimiento_estudiante->format('Y-m-d') : '',
                'tipo_identificacion' => $estudiante->tipo_identificacion_estudiante ?? 'CC',
            ]);
        }

        return response()->json(['encontrado' => false]);
    }
}
