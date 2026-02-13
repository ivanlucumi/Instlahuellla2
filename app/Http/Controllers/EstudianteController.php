<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiantes = Estudiante::with(['user', 'acudiente.user', 'gradoAcademico'])->orderBy('id', 'desc')->paginate(15);
        
        return view('Estudiante.Index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        $acudientes = \App\Models\Acudiente::with('user')->get();
        $grados = \App\Models\GradoAcademico::orderBy('nombre_grado')->get();
        return view('Estudiante.Edit', compact('estudiante', 'acudientes', 'grados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
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


    public function notasPeriodo(){
         return view('estudiante.estudiante');
    }

    public function storeQuick(Request $request)
    {
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
}
