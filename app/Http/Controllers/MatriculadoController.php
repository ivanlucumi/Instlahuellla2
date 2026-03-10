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
        $matriculados = MatriculaFinal::with([
            'estudiante.user',
            'sede',
            'grado',
            'profesor'
        ])->orderBy('id', 'desc')->paginate(15);
        
        return view('Matriculado.Index', compact('matriculados'));
    }

    public function create()
    {
        $matriculado = new MatriculaFinal(); 
        $estudiantes = Estudiante::with('user')->orderBy('id')->get();
        // Cargar todos los catálogos para los dropdowns
        $sedes = Sede::orderBy('nombre_sede')->get();
        $grados = GradoAcademico::where('estado_grado_academico', true)->orderBy('nombre_grado')->get();
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)->orderBy('nombre_anho_escolar', 'desc')->get();
        $docentes = User::whereHas('roles', fn($q) => $q->where('name', 'Docente'))->orderBy('name')->get();
        $acudientes = Acudiente::with('user')->orderBy('id')->get();

        return view('Matriculado.Create', compact(
            'matriculado', 'estudiantes', 'sedes', 'grados', 'anhosEscolares', 'docentes', 'acudientes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento_estudiante' => 'required|exists:estudiantes,numero_identificacion_estudiante',
            'id_sede'              => 'required|exists:sedes,id',
            'id_grado'             => 'required|exists:grado_academicos,id',
            'curso'                => 'required|string',
            'ano_lectivo'          => 'required|string',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:activo,inactivo,retirado',
            'id_profesor'          => 'nullable|exists:users,id',
            'documento_acudiente'  => 'nullable|string',
            'parentezco_acudiente' => 'nullable|string',
        ]);

        // Validar duplicado
        $existe = MatriculaFinal::where('documento_estudiante', $request->documento_estudiante)
            ->where('ano_lectivo', $request->ano_lectivo)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'documento_estudiante' => 'Este estudiante ya tiene una matrícula final para el año escolar seleccionado.'
            ])->withInput();
        }

        MatriculaFinal::create($request->all());

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
        $anhosEscolares = AnhoEscolar::where('estado_anho_escolar', true)->orderBy('nombre_anho_escolar', 'desc')->get();
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
            'email'                => 'required|string|email|max:255|unique:users,email,' . ($matricula->estudiante->user->id ?? ''),
            'celular_estudiante'   => 'nullable|string|max:20',
            'direccion_estudiante' => 'nullable|string|max:255',
            'id_sede'              => 'required|exists:sedes,id',
            'id_grado'             => 'required|exists:grado_academicos,id',
            'curso'                => 'required|string',
            'ano_lectivo'          => 'required|string',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:activo,inactivo,retirado',
            'id_profesor'          => 'nullable|exists:users,id',
            'documento_acudiente'  => 'nullable|string',
            'parentezco_acudiente' => 'nullable|string',
        ]);

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
                    'celular_estudiante'   => $request->celular_estudiante,
                    'direccion_estudiante' => $request->direccion_estudiante,
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
                'id_sede'              => $request->id_sede,
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
        $matricula = MatriculaFinal::findOrFail($id);
        $matricula->delete();

        return redirect()->route('admin.matriculado.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminada',
            'text'  => 'La matrícula fue eliminada correctamente.'
        ]);
    }
}
