<?php

namespace App\Http\Controllers;

use App\Models\MatriculaFinal;
use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Acudiente;
use App\Models\GradoAcademico;
use App\Models\AnhoEscolar;
use App\Models\User;
use App\Models\Sede;
use Illuminate\Http\Request;

class MatriculadoController extends Controller
{
    public function index()
    {
        $query = MatriculaFinal::with([
            'estudiante.user',
            'sede',
            'grado.sede',
            'grado',
            'acudiente.user',
            'profesor'
        ]);

        if (auth()->user()->hasRol('DIRECTOR') && !auth()->user()->hasRol('SUPERADMIN') && !auth()->user()->hasRol('ADMIN')) {
            $directorId = auth()->id();
            $query->whereHas('grado', function ($q) use ($directorId) {
                $q->whereHas('docente', function ($sq) use ($directorId) {
                    $sq->where('user_id', $directorId);
                });
            });
        }

        $matriculados = $query->orderBy('id', 'desc')->paginate(15);
        return view('Matriculado.Index', compact('matriculados'));
    }

    public function create()
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'ADMIN']), 403, 'No tiene permisos para crear matriculas.');
        $matriculado    = new MatriculaFinal();
        $estudiantes    = Estudiante::with('user')->orderBy('id')->get();
        $sedes          = Sede::orderBy('nombre_sede')->get();
        $grados         = GradoAcademico::with('docente.user')->where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        $currentYear    = date('Y');
        $anhosEscolares = AnhoEscolar::orderBy('nombre_anho_escolar', 'asc')->get();
        $docentes       = User::whereIn('id', \App\Models\Docente::pluck('user_id')->filter())
            ->orWhereHas('roles', fn($q) => $q->where('name', 'Docente'))
            ->orderBy('name')->get();
        $acudientes     = Acudiente::with('user')->orderBy('id')->get();

        return view('Matriculado.Create', compact(
            'matriculado', 'estudiantes', 'sedes', 'grados',
            'anhosEscolares', 'docentes', 'acudientes'
        ));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'ADMIN']), 403, 'No tiene permisos para crear matriculas.');

        $docEstudiante       = trim($request->documento_estudiante);
        $estudianteExistente = Estudiante::with('user')
            ->where('numero_identificacion_estudiante', $docEstudiante)
            ->first();

        // --- Reglas de validacion ---
        $rules = [
            'documento_estudiante' => 'required|string|max:20',
            'id_grado'             => 'required|exists:grado_academicos,id',
            'curso'                => 'required|string|max:20',
            'ano_lectivo'          => 'required|string|max:10',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:activo,inactivo,retirado',
            'id_profesor'          => 'nullable|exists:users,id',
            'documento_acudiente'  => 'nullable|string|max:20',
        ];

        // Solo requerir nombre y nacimiento si el estudiante NO existe
        if (!$estudianteExistente) {
            $rules['name']                       = 'required|string|max:255';
            $rules['fecha_nacimiento_estudiante'] = 'required|date';
        }

        $request->validate($rules, [
            'id_grado.required'                   => 'Seleccione un grado academico.',
            'ano_lectivo.required'                => 'Seleccione el ano lectivo.',
            'name.required'                       => 'El nombre del estudiante es obligatorio para registros nuevos.',
            'fecha_nacimiento_estudiante.required' => 'La fecha de nacimiento es obligatoria para registros nuevos.',
        ]);

        // Validar email unico solo para estudiantes nuevos
        if (!$estudianteExistente && $request->filled('email')) {
            if (User::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'El correo ya esta registrado. Use otro o dejelo vacio.'])->withInput();
            }
        }

        \DB::transaction(function () use ($request, $docEstudiante, $estudianteExistente) {

            $grado  = GradoAcademico::with(['docente.user', 'asignaturas'])->findOrFail($request->id_grado);
            $sedeId = $grado->sede_id;

            // Resolve id_profesor to avoid null or invalid integrity constraint
            $docenteUserId = $request->id_profesor;
            if (!$docenteUserId && $grado->docente) {
                $docenteUserId = $grado->docente->user_id;
            }
            if ($docenteUserId && !User::find($docenteUserId)) {
                $docenteUserId = null;
            }
            if (!$docenteUserId) {
                $docenteUserId = User::whereHas('roles', fn($q) => $q->where('name', 'Docente'))->value('id');
            }
            if (!$docenteUserId) {
                $docenteUserId = auth()->id();
            }

            // =============================================
            // PASO 1: ACUDIENTE
            // =============================================
            $acudienteId  = null;
            $docAcudiente = trim($request->documento_acudiente ?? '');

            if ($docAcudiente) {
                $acudienteObj = Acudiente::where('id_documento', $docAcudiente)->first();

                if (!$acudienteObj) {
                    // Acudiente nuevo: crear usuario
                    $emailAcud = 'acudiente_' . $docAcudiente . '@colegio.local';
                    if (User::where('email', $emailAcud)->exists()) {
                        $emailAcud = 'acudiente_' . $docAcudiente . '_' . time() . '@colegio.local';
                    }

                    $userAcud = User::create([
                        'name'     => $request->nombre_acudiente ?? 'Acudiente ' . $docAcudiente,
                        'email'    => $emailAcud,
                        'password' => \Hash::make($docAcudiente),
                        'genero'   => 'no definido',
                    ]);
                    $rolAcud = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
                    if ($rolAcud) $userAcud->roles()->attach($rolAcud->id);

                    $acudienteObj = Acudiente::create([
                        'user_id'              => $userAcud->id,
                        'id_documento'         => $docAcudiente,
                        'celular_acudiente'    => $request->celular_acudiente ?? '0000000000',
                        'direccion_acudiente'  => 'N/A',
                        'genero_acudiente'     => 'no definido',
                        'parentesco_acudiente' => $request->parentezco_acudiente ?? 'Acudiente',
                        'estado_acudiente'     => 1,
                    ]);
                } else {
                    // Acudiente existente: actualizar si vinieron datos
                    if ($request->nombre_acudiente && $acudienteObj->user) {
                        $acudienteObj->user->update(['name' => $request->nombre_acudiente]);
                    }
                    if ($request->celular_acudiente) {
                        $acudienteObj->update(['celular_acudiente' => $request->celular_acudiente]);
                    }
                    if ($request->parentezco_acudiente) {
                        $acudienteObj->update(['parentesco_acudiente' => $request->parentezco_acudiente]);
                    }
                }
                $acudienteId = $acudienteObj->id;
            }

            // =============================================
            // PASO 2: ESTUDIANTE + USUARIO
            // =============================================
            if (!$estudianteExistente) {
                // Estudiante NUEVO -> crear usuario + perfil
                $emailEst = $request->filled('email')
                    ? $request->email
                    : 'est_' . $docEstudiante . '@colegio.local';
                if (User::where('email', $emailEst)->exists()) {
                    $emailEst = 'est_' . $docEstudiante . '_' . time() . '@colegio.local';
                }

                $userEst = User::create([
                    'name'     => $request->name,
                    'email'    => $emailEst,
                    'password' => \Hash::make($docEstudiante), // contrasena = documento
                    'genero'   => $request->genero_estudiante ?? 'no definido',
                ]);
                $rolEst = \App\Models\Rol::where('nombre', 'ESTUDIANTE')->first();
                if ($rolEst) $userEst->roles()->attach($rolEst->id);

                $estudiante = Estudiante::create([
                    'user_id'                         => $userEst->id,
                    'codigo_estudiante'               => 'ES' . $docEstudiante,
                    'tipo_identificacion_estudiante'  => $request->tipo_identificacion_estudiante ?? 'TI',
                    'numero_identificacion_estudiante' => $docEstudiante,
                    'fecha_nacimiento_estudiante'     => $request->fecha_nacimiento_estudiante,
                    'genero_estudiante'               => $request->genero_estudiante ?? 'no definido',
                    'direccion_estudiante'            => $request->direccion_estudiante ?? 'N/A',
                    'telefono_estudiante'             => $request->celular_estudiante ?? '0000000000',
                    'estado_estudiante'               => 1,
                    'grado_academico_id'              => (int) $request->id_grado,
                    'acudiente_id'                   => $acudienteId,
                ]);

            } else {
                // Estudiante EXISTENTE -> actualizar datos si vinieron
                $estudiante = $estudianteExistente;

                if ($estudiante->user) {
                    $upUser = [];
                    if ($request->filled('name'))  $upUser['name']  = $request->name;
                    if ($request->filled('email')) $upUser['email'] = $request->email;
                    if (!empty($upUser)) $estudiante->user->update($upUser);
                }

                $estudiante->update([
                    'grado_academico_id'             => (int) $request->id_grado,
                    'acudiente_id'                   => $acudienteId ?? $estudiante->acudiente_id,
                    'fecha_nacimiento_estudiante'    => $request->fecha_nacimiento_estudiante ?? $estudiante->fecha_nacimiento_estudiante,
                    'direccion_estudiante'           => $request->direccion_estudiante ?? $estudiante->direccion_estudiante,
                    'genero_estudiante'              => $request->genero_estudiante ?? $estudiante->genero_estudiante,
                    'tipo_identificacion_estudiante' => $request->tipo_identificacion_estudiante ?? $estudiante->tipo_identificacion_estudiante,
                ]);
            }

            // Vincular acudiente al estudiante si corresponde
            if ($acudienteId) {
                $estudiante->update(['acudiente_id' => $acudienteId]);
            }

            // =============================================
            // PASO 3: MATRICULA FINAL
            // =============================================
            // Insertar siempre como nuevo para no borrar el registro histórico de matriculados listados.
            $matriculaFinalInstance = MatriculaFinal::create([
                'documento_estudiante' => $docEstudiante,
                'id_sede'              => $sedeId,
                'id_grado'             => (int) $request->id_grado,
                'curso'                => $request->curso,
                'ano_lectivo'          => $request->ano_lectivo,
                'fecha'                => $request->fecha,
                'estado'               => $request->estado,
                'id_profesor'          => $docenteUserId,
                'documento_acudiente'  => $docAcudiente ?: null,
                'parentezco_acudiente' => $request->parentezco_acudiente ?? null,
            ]);

            // =============================================
            // PASO 4: PRE-POBULAR MATERIAS EN NOTAS DEFINITIVAS
            // =============================================
            $asignaturas = $grado->asignaturas;
            foreach ($asignaturas as $asignatura) {
                $nd = \App\Models\NotasDefinitivas::firstOrNew([
                    'id_matricula'  => $matriculaFinalInstance->id,
                    'asignatura_id' => $asignatura->id,
                ]);

                if (!$nd->exists) {
                    $nd->nota_per1 = 0.00;
                    $nd->nota_per2 = 0.00;
                    $nd->nota_per3 = 0.00;
                    $nd->nota_per4 = 0.00;
                    $nd->nota_definitiva = 0.00;
                }

                $nd->documento_estudiante = $docEstudiante;
                $nd->nombre_estudiante    = $estudiante->user->name;
                $nd->grado_aprobado       = $grado->nombre_grado . ' - ' . ($grado->bloque ?? '');
                $nd->nombre_asignatura    = $asignatura->nombre_asignatura;
                $nd->curso                = $request->curso;
                $nd->save();
            }
        }); // fin transaction

        $esNuevo = !$estudianteExistente;
        $msg = "Estudiante matriculado exitosamente en {$request->ano_lectivo}.";
        if ($esNuevo) {
            $msg .= " Se creo el usuario en el sistema. Contrasena de acceso: {$docEstudiante}";
        }

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Matricula Registrada!',
            'text'  => $msg,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'ADMIN']), 403, 'No tiene permisos para editar matriculas.');
        $matriculado    = MatriculaFinal::findOrFail($id);
        $estudiantes    = Estudiante::with('user')->orderBy('id')->get();
        $sedes          = Sede::orderBy('nombre_sede')->get();
        $grados         = GradoAcademico::with('docente.user')->where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        $currentYear    = date('Y');
        $anhosEscolares = AnhoEscolar::orderBy('nombre_anho_escolar', 'asc')->get();
        $docentes       = User::whereIn('id', \App\Models\Docente::pluck('user_id')->filter())
            ->orWhereHas('roles', fn($q) => $q->where('name', 'Docente'))
            ->orderBy('name')->get();
        $acudientes     = Acudiente::with('user')->orderBy('id')->get();

        return view('Matriculado.Edit', compact(
            'matriculado', 'estudiantes', 'sedes', 'grados',
            'anhosEscolares', 'docentes', 'acudientes'
        ));
    }

    public function update(Request $request, $id)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'ADMIN']), 403, 'No tiene permisos para editar matriculas.');

        $matricula = MatriculaFinal::with('estudiante.user')->findOrFail($id);

        if ($matricula->estado !== 'activo') {
            return back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Matricula no editable',
                'text'  => 'Solo se pueden modificar matriculas en estado ACTIVO. Esta esta en estado: ' . strtoupper($matricula->estado) . '.',
            ])->withInput();
        }

        $docEstudiante = $matricula->documento_estudiante;
        $userId        = $matricula->estudiante?->user?->id ?? '';

        $request->validate([
            'name'                       => 'required|string|max:255',
            'email'                      => 'nullable|string|email|max:255|unique:users,email,' . $userId,
            'fecha_nacimiento_estudiante' => 'required|date',
            'celular_estudiante'         => 'nullable|string|max:20',
            'direccion_estudiante'       => 'nullable|string|max:255',
            'id_grado'                   => 'required|exists:grado_academicos,id',
            'curso'                      => 'required|string',
            'ano_lectivo'                => 'required|string',
            'fecha'                      => 'required|date',
            'estado'                     => 'required|in:activo,inactivo,retirado',
            'id_profesor'                => 'nullable|exists:users,id',
            'documento_acudiente'        => 'nullable|string',
            'parentezco_acudiente'       => 'nullable|string',
        ], [
            'email.unique' => 'El correo electronico ya pertenece a otro usuario registrado en el sistema.',
        ]);

        $conflicto = MatriculaFinal::where('documento_estudiante', $docEstudiante)
            ->where('ano_lectivo', $request->ano_lectivo)
            ->where('id', '!=', $id)
            ->first();

        if ($conflicto) {
            return back()->withErrors([
                'ano_lectivo' => "El estudiante con documento {$docEstudiante} ya tiene una matricula registrada para el ano {$request->ano_lectivo}."
            ])->withInput();
        }

        \DB::transaction(function () use ($request, $matricula) {
            $grado   = GradoAcademico::with(['docente.user', 'asignaturas'])->findOrFail($request->id_grado);
            $sedeId  = $grado ? $grado->sede_id : null;

            if ($matricula->estudiante && $matricula->estudiante->user) {
                $matricula->estudiante->user->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);
            }

            if ($matricula->estudiante) {
                $matricula->estudiante->update([
                    'fecha_nacimiento_estudiante' => $request->fecha_nacimiento_estudiante,
                    'telefono_estudiante'         => $request->celular_estudiante,
                    'direccion_estudiante'        => $request->direccion_estudiante,
                    'genero_estudiante'           => $request->genero_estudiante,
                    'grado_academico_id'          => (int) $request->id_grado,
                ]);
            }

            $docAcudiente = $request->documento_acudiente;
            if ($docAcudiente) {
                $acudiente = Acudiente::where('id_documento', $docAcudiente)->first();

                if (!$acudiente) {
                    $emailAcud = 'acudiente_' . $docAcudiente . '@colegio.local';
                    if (User::where('email', $emailAcud)->exists()) {
                        $emailAcud = 'acudiente_' . $docAcudiente . '_' . time() . '@colegio.local';
                    }
                    $userAcud = User::create([
                        'name'     => $request->nombre_acudiente ?? 'Acudiente ' . $docAcudiente,
                        'email'    => $emailAcud,
                        'password' => \Hash::make($docAcudiente),
                        'genero'   => 'no definido',
                    ]);
                    $rolAcud = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
                    if ($rolAcud) $userAcud->roles()->attach($rolAcud->id);

                    $acudiente = Acudiente::create([
                        'user_id'              => $userAcud->id,
                        'id_documento'         => $docAcudiente,
                        'celular_acudiente'    => $request->celular_acudiente ?? '0000000000',
                        'direccion_acudiente'  => 'N/A',
                        'genero_acudiente'     => 'no definido',
                        'parentesco_acudiente' => $request->parentezco_acudiente ?? 'Acudiente',
                        'estado_acudiente'     => 1,
                    ]);
                } else {
                    if ($request->parentezco_acudiente) {
                        $acudiente->update(['parentesco_acudiente' => $request->parentezco_acudiente]);
                    }
                }

                if ($matricula->estudiante) {
                    $matricula->estudiante->update(['acudiente_id' => $acudiente->id]);
                }
            }

            // Resolve id_profesor to avoid null or invalid integrity constraint
            $docenteUserId = $request->id_profesor;
            if (!$docenteUserId && $grado->docente) {
                $docenteUserId = $grado->docente->user_id;
            }
            if ($docenteUserId && !User::find($docenteUserId)) {
                $docenteUserId = null;
            }
            if (!$docenteUserId) {
                $docenteUserId = User::whereHas('roles', fn($q) => $q->where('name', 'Docente'))->value('id');
            }
            if (!$docenteUserId) {
                $docenteUserId = auth()->id();
            }

            $matricula->update([
                'id_sede'              => $sedeId,
                'id_grado'             => $request->id_grado,
                'curso'                => $request->curso,
                'ano_lectivo'          => $request->ano_lectivo,
                'fecha'                => $request->fecha,
                'estado'               => $request->estado,
                'id_profesor'          => $docenteUserId,
                'documento_acudiente'  => $docAcudiente ?: null,
                'parentezco_acudiente' => $request->parentezco_acudiente ?? null,
            ]);

            // =============================================
            // PASO 4: PRE-POBULAR MATERIAS EN NOTAS DEFINITIVAS
            // =============================================
            $asignaturas = $grado->asignaturas;
            foreach ($asignaturas as $asignatura) {
                $nd = \App\Models\NotasDefinitivas::firstOrNew([
                    'id_matricula'  => $matricula->id,
                    'asignatura_id' => $asignatura->id,
                ]);

                if (!$nd->exists) {
                    $nd->nota_per1 = 0.00;
                    $nd->nota_per2 = 0.00;
                    $nd->nota_per3 = 0.00;
                    $nd->nota_per4 = 0.00;
                    $nd->nota_definitiva = 0.00;
                }

                $nd->documento_estudiante = $matricula->documento_estudiante;
                $nd->nombre_estudiante    = $matricula->estudiante->user->name ?? '';
                $nd->grado_aprobado       = $grado->nombre_grado . ' - ' . ($grado->bloque ?? '');
                $nd->nombre_asignatura    = $asignatura->nombre_asignatura;
                $nd->curso                = $request->curso;
                $nd->save();
            }
        });

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Actualizado!',
            'text'  => 'La matricula y los datos del estudiante fueron actualizados correctamente.'
        ]);
    }

    public function destroy($id)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Super Administrador puede eliminar registros.');
        $matricula = MatriculaFinal::findOrFail($id);
        $matricula->delete();

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La matricula fue eliminada correctamente.'
        ]);
    }

    /**
     * AJAX: Busqueda de estudiantes para Select2.
     */
    public function searchStudents(Request $request)
    {
        $term = $request->get('q');

        $estudiantes = Estudiante::with('user')
            ->where(function ($query) use ($term) {
                $query->where('numero_identificacion_estudiante', 'LIKE', "%$term%")
                    ->orWhereHas('user', function ($q) use ($term) {
                        $q->where('name', 'LIKE', "%$term%");
                    });
            })
            ->limit(20)
            ->get();

        $results = $estudiantes->map(function ($e) {
            return [
                'id'               => $e->numero_identificacion_estudiante,
                'text'             => ($e->user->name ?? 'Sin Nombre') . " (" . $e->numero_identificacion_estudiante . ")",
                'name'             => $e->user->name ?? '',
                'fecha_nacimiento' => $e->fecha_nacimiento_estudiante,
                'email'            => $e->user->email ?? '',
                'tipo_id'          => $e->tipo_identificacion_estudiante,
                'celular'          => $e->telefono_estudiante,
                'genero'           => $e->genero_estudiante,
                'direccion'        => $e->direccion_estudiante,
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * AJAX: Pre-poblar formulario de matricula al buscar por documento.
     */
    public function datosEstudiante(Request $request)
    {
        $documento = $request->query('documento');

        if (!$documento) {
            return response()->json(['encontrado' => false], 400);
        }

        $estudiante = Estudiante::with('user')
            ->where('numero_identificacion_estudiante', $documento)
            ->first();

        $ultimaMatricula = MatriculaFinal::with('grado.sede')
            ->where('documento_estudiante', $documento)
            ->latest()
            ->first();

        if (!$estudiante && !$ultimaMatricula) {
            return response()->json(['encontrado' => false]);
        }

        return response()->json([
            'encontrado'           => true,
            'name'                 => $estudiante?->user?->name ?? '',
            'email'                => $estudiante?->user?->email ?? '',
            'genero_estudiante'    => $estudiante?->genero_estudiante ?? '',
            'celular_estudiante'   => $estudiante?->telefono_estudiante ?? '',
            'direccion_estudiante' => $estudiante?->direccion_estudiante ?? '',
            'fecha_nacimiento'     => $estudiante?->fecha_nacimiento_estudiante
                ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento_estudiante)->format('Y-m-d')
                : '',
            'tipo_id'              => $estudiante?->tipo_identificacion_estudiante ?? 'TI',
            'ultima_matricula'     => $ultimaMatricula ? [
                'id_grado'     => $ultimaMatricula->id_grado,
                'nombre_grado' => $ultimaMatricula->grado?->nombre_grado ?? '',
                'sede'         => $ultimaMatricula->grado?->sede?->nombre_sede ?? '',
                'curso'        => $ultimaMatricula->curso,
                'ano_lectivo'  => $ultimaMatricula->ano_lectivo,
                'estado'       => $ultimaMatricula->estado,
            ] : null,
        ]);
    }
}
