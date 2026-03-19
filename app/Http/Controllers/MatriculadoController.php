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
            'grado',
            'profesor'
        ]);

        // Si es DIRECTOR y no SUPERADMIN/ADMIN, solo ve matrículas de sus grados asignados
        if (auth()->user()->hasRol('DIRECTOR') && !auth()->user()->hasRol('SUPERADMIN') && !auth()->user()->hasRol('ADMIN')) {
            $directorId = auth()->id();
            $query->whereHas('grado', function($q) use ($directorId) {
                $q->whereHas('docente', function($sq) use ($directorId) {
                    $sq->where('user_id', $directorId);
                });
            });
        }

        $matriculados = $query->orderBy('id', 'desc')->paginate(15);
        
        return view('Matriculado.Index', compact('matriculados'));
    }

    public function create()
    {
        $matriculado = new MatriculaFinal(); 
        $estudiantes = Estudiante::with('user')->orderBy('id')->get();
        // Cargar todos los catálogos para los dropdowns
        $sedes = Sede::orderBy('nombre_sede')->get();
        $grados = GradoAcademico::where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        
        $currentYear = date('Y');
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)
            ->where('nombre_anho_escolar', '>=', $currentYear)
            ->orderBy('nombre_anho_escolar', 'asc')
            ->get();
            
        $docentes = User::whereHas('roles', fn($q) => $q->where('name', 'Docente'))->orderBy('name')->get();
        $acudientes = Acudiente::with('user')->orderBy('id')->get();

        return view('Matriculado.Create', compact(
            'matriculado', 'estudiantes', 'sedes', 'grados', 'anhosEscolares', 'docentes', 'acudientes'
        ));
    }

    public function store(Request $request)
    {
        $docEstudiante = $request->documento_estudiante;
        $estudiante = \App\Models\Estudiante::where('numero_identificacion_estudiante', $docEstudiante)->first();
        $userId = $estudiante ? $estudiante->user_id : null;

        $request->validate([
            'documento_estudiante' => 'required|string',
            'id_grado'             => 'required|exists:grado_academicos,id',
            'curso'                => 'required|string',
            'ano_lectivo'          => 'required|string',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:activo,inactivo,retirado',
            'id_profesor'          => 'nullable|exists:users,id',
            'documento_acudiente'  => 'nullable|string',
            // student direct fields
            'name'                        => 'required|string',
            'email'                       => 'nullable|email|unique:users,email,' . $userId,
            'fecha_nacimiento_estudiante'  => 'required|date',
        ], [
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario en el sistema. Debe usar uno distinto o dejarlo vacío si el estudiante no cuenta con uno.'
        ]);

        // Validar duplicado exacto
        $existe = MatriculaFinal::where('documento_estudiante', $request->documento_estudiante)
            ->where('ano_lectivo', $request->ano_lectivo)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'documento_estudiante' => 'Este estudiante ya tiene una matrícula para el año lectivo seleccionado.'
            ])->withInput();
        }

        \DB::transaction(function() use ($request) {
            // Determinar Sede basado en el Grado Académico
            $grado = \App\Models\GradoAcademico::find($request->id_grado);
            $realSedeId = $grado ? $grado->sede_id : null;

            $docEstudiante = $request->documento_estudiante;
            $estudiante = \App\Models\Estudiante::where('numero_identificacion_estudiante', $docEstudiante)->first();

            if (!$estudiante) {
                // 1. Crear Usuario Estudiante
                $userEstudiante = \App\Models\User::create([
                    'name'     => $request->name,
                    'email'    => $request->email ?? 'estudiante_'.$docEstudiante.'@colegio.local',
                    'password' => \Hash::make($docEstudiante),
                    'genero'   => $request->genero_estudiante ?? 'no definido',
                ]);

                $rolEstudiante = \App\Models\Rol::where('nombre', 'ESTUDIANTE')->first();
                if ($rolEstudiante) {
                    $userEstudiante->roles()->attach($rolEstudiante->id);
                }

                // 2. Crear Estudiante
                $estudiante = \App\Models\Estudiante::create([
                    'user_id'                          => $userEstudiante->id,
                    'codigo_estudiante'                => 'ES' . $docEstudiante,
                    'tipo_identificacion_estudiante'   => $request->tipo_identificacion_estudiante ?? 'CC',
                    'numero_identificacion_estudiante' => $docEstudiante,
                    'fecha_nacimiento_estudiante'      => $request->fecha_nacimiento_estudiante,
                    'celular_estudiante'               => $request->celular_estudiante ?? '00000',
                    'direccion_estudiante'             => $request->direccion_estudiante ?? 'N/A',
                    'genero_estudiante'                => $request->genero_estudiante ?? 'no definido',
                    'estado_estudiante'                => 1,
                    'grado_academico_id'               => $request->id_grado,
                 ]);
            } else {
                // Actualizar info si ya existía
                if ($estudiante->user) {
                    $estudiante->user->update([
                        'name' => $request->name,
                        'email' => $request->email ?? $estudiante->user->email
                    ]);
                }
                $estudiante->update([
                    'fecha_nacimiento_estudiante'    => $request->fecha_nacimiento_estudiante ?? $estudiante->fecha_nacimiento_estudiante,
                    'celular_estudiante'             => $request->celular_estudiante ?? $estudiante->celular_estudiante,
                    'direccion_estudiante'           => $request->direccion_estudiante ?? $estudiante->direccion_estudiante,
                    'tipo_identificacion_estudiante' => $request->tipo_identificacion_estudiante ?? $estudiante->tipo_identificacion_estudiante,
                    'genero_estudiante'              => $request->genero_estudiante ?? $estudiante->genero_estudiante,
                ]);
            }

            $docAcudiente = $request->documento_acudiente;
            $acudienteId = null;

            if ($docAcudiente) {
                $acudienteObj = \App\Models\Acudiente::where('id_documento', $docAcudiente)->first();

                if (!$acudienteObj) {
                    // 1. Crear Usuario Acudiente
                    $userAcudiente = \App\Models\User::create([
                        'name'     => $request->nombre_acudiente ?? 'Acudiente ' . $docAcudiente,
                        'email'    => 'acudiente_'.$docAcudiente.'@colegio.local',
                        'password' => \Hash::make($docAcudiente),
                        'genero'   => 'no definido',
                    ]);

                    $rolAcudiente = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
                    if ($rolAcudiente) {
                        $userAcudiente->roles()->attach($rolAcudiente->id);
                    }

                    // 2. Crear Perfil Acudiente
                    $acudienteObj = \App\Models\Acudiente::create([
                        'user_id'              => $userAcudiente->id,
                        'id_documento'         => $docAcudiente,
                        'celular_acudiente'    => $request->celular_acudiente ?? '00000',
                        'direccion_acudiente'  => 'N/A',
                        'genero_acudiente'     => 'no definido',
                        'parentesco_acudiente' => $request->parentezco_acudiente ?? 'Acudiente',
                        'estado_acudiente'     => 1,
                    ]);
                } else {
                    // Actualizar Acudiente si existe y mandaron datos nuevos
                    if ($acudienteObj->user && $request->nombre_acudiente) {
                        $acudienteObj->user->update(['name' => $request->nombre_acudiente]);
                    }
                    if ($request->celular_acudiente || $request->parentezco_acudiente) {
                       $acudienteObj->update([
                           'celular_acudiente' => $request->celular_acudiente ?? $acudienteObj->celular_acudiente,
                           'parentesco_acudiente' => $request->parentezco_acudiente ?? $acudienteObj->parentesco_acudiente
                       ]);
                    }
                }

                $acudienteId = $acudienteObj->id;
                $estudiante->update(['acudiente_id' => $acudienteId]);
            }

            // Crear Matrícula
            MatriculaFinal::create([
                'documento_estudiante' => $docEstudiante,
                'id_sede'              => $realSedeId,
                'id_grado'             => $request->id_grado,
                'curso'                => $request->curso,
                'ano_lectivo'          => $request->ano_lectivo,
                'fecha'                => $request->fecha,
                'estado'               => $request->estado,
                'id_profesor'          => $request->id_profesor,
                'documento_acudiente'  => $docAcudiente,
                'parentezco_acudiente' => $request->parentezco_acudiente,
            ]);
        });

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El estudiante fue matriculado correctamente.'
        ]);
    }

    // Adapt the edit, update, delete routing by expecting $id. Laravel might inject Matriculado, but since the model on route could be mismatched, we take $id.
    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        $matriculado = MatriculaFinal::findOrFail($id);
        $estudiantes = Estudiante::with('user')->orderBy('id')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();
        $grados = GradoAcademico::where('estado_grado_academico', true)->orderBy('nombre_grado')->get();

        $currentYear = date('Y');
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)
            ->where('nombre_anho_escolar', '>=', $currentYear)
            ->orderBy('nombre_anho_escolar', 'asc')
            ->get();
            
        $docentes = User::whereHas('roles', fn($q) => $q->where('name', 'Docente'))->orderBy('name')->get();
        $acudientes = Acudiente::with('user')->orderBy('id')->get();

        return view('Matriculado.Edit', compact(
            'matriculado', 'estudiantes', 'sedes', 'grados', 'anhosEscolares', 'docentes', 'acudientes'
        ));
    }

    public function update(Request $request, $id)
    {
        $matricula = MatriculaFinal::with('estudiante.user')->findOrFail($id);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|string|email|max:255|unique:users,email,' . ($matricula->estudiante->user->id ?? ''),
            'fecha_nacimiento_estudiante' => 'required|date',
            'celular_estudiante'   => 'nullable|string|max:20',
            'direccion_estudiante' => 'nullable|string|max:255',
            'id_grado'             => 'required|exists:grado_academicos,id',
            'curso'                => 'required|string',
            'ano_lectivo'          => 'required|string',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:activo,inactivo,retirado',
            'id_profesor'          => 'nullable|exists:users,id',
            'documento_acudiente'  => 'nullable|string',
            'parentezco_acudiente' => 'nullable|string',        ]);

        $existe = MatriculaFinal::where('documento_estudiante', $matricula->documento_estudiante)
            ->where('ano_lectivo', $request->ano_lectivo)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'ano_lectivo' => 'Este estudiante ya tiene otra matrícula para el año escolar seleccionado.'
            ])->withInput();
        }

        \DB::transaction(function() use ($request, $matricula) {
            // Determinar Sede basado en el Grado Académico
            $grado = \App\Models\GradoAcademico::find($request->id_grado);
            $realSedeId = $grado ? $grado->sede_id : null;

            // Actualizar User
            if ($matricula->estudiante && $matricula->estudiante->user) {
                $matricula->estudiante->user->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);
            }

            // Actualizar Estudiante Profile
            if ($matricula->estudiante) {
                $matricula->estudiante->update([
                    'fecha_nacimiento_estudiante' => $request->fecha_nacimiento_estudiante,
                    'celular_estudiante'          => $request->celular_estudiante,
                    'direccion_estudiante'        => $request->direccion_estudiante,
                    'genero_estudiante'           => $request->genero_estudiante,
                ]);
            }

            // Procesar Acudiente
            $docAcudiente = $request->documento_acudiente;
            if ($docAcudiente) {
                $acudiente = Acudiente::where('id_documento', $docAcudiente)->first();

                if (!$acudiente) {
                    // 1. Crear Usuario Acudiente
                    $userAcudiente = \App\Models\User::create([
                        'name'     => $request->nombre_acudiente ?? 'Acudiente ' . $docAcudiente,
                        'email'    => 'acudiente_'.$docAcudiente.'@colegio.local',
                        'password' => \Hash::make($docAcudiente),
                        'genero'   => 'no definido',
                    ]);

                    // 2. Asignar Rol ACUDIENTE
                    $rolAcudiente = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
                    if ($rolAcudiente) {
                        $userAcudiente->roles()->attach($rolAcudiente->id);
                    }

                    // 3. Crear Perfil Acudiente
                    $acudiente = Acudiente::create([
                        'user_id'              => $userAcudiente->id,
                        'id_documento'         => $docAcudiente, // <- Ensure Acudiente model matches this, check migration/model. Actually, the table uses id_documento per previous inquiry.
                        'celular_acudiente'    => $request->celular_acudiente ?? '00000',
                        'direccion_acudiente'  => 'N/A',
                        'genero_acudiente'     => 'no definido',
                        'parentesco_acudiente' => $request->parentezco_acudiente ?? 'Acudiente',
                        'estado_acudiente'     => 1,
                    ]);
                } else {
                    // If exists but they typed a name or phone in the readonly (disabled via inspector), we could update but better to respect original.
                    // Just update parentesco if changed.
                    if($request->parentezco_acudiente){
                         $acudiente->update(['parentesco_acudiente' => $request->parentezco_acudiente]);
                    }
                }

                // Asegurar que el estudiante se vincule con el ID del Acudiente
                if ($matricula->estudiante) {
                    $matricula->estudiante->update([
                        'acudiente_id' => $acudiente->id
                    ]);
                }
            }

            // Actualizar Matrícula
            $matricula->update([
                'id_sede'              => $realSedeId,
                'id_grado'             => $request->id_grado,
                'curso'                => $request->curso,
                'ano_lectivo'          => $request->ano_lectivo,
                'fecha'                => $request->fecha,
                'estado'               => $request->estado,
                'id_profesor'          => $request->id_profesor,
                'documento_acudiente'  => $docAcudiente,
                'parentezco_acudiente' => $request->parentezco_acudiente,
            ]);
        });

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Actualizado!',
            'text'  => 'La matrícula y los datos del estudiante fueron actualizados correctamente.'
        ]);
    }

    public function destroy($id)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $matricula = MatriculaFinal::findOrFail($id);
        $matricula->delete();

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La matrícula fue eliminada correctamente.'
        ]);
    }
}
