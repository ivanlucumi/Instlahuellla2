<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('id', 'desc');

        // Búsqueda por nombre o email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        // Filtro por Rol
        if ($request->filled('rol_id')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('rol.id', $request->rol_id);
            });
        }

        // Filtro por Género
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        $perPage = $request->get('per_page', 10);
        $usuarios = $query->paginate($perPage)->appends($request->all());
        
        $roles = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.index', compact('usuarios', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.crear', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'genero'   => 'nullable|string',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:rol,id'
        ]);

        DB::transaction(function() use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'genero'   => $request->genero,
            ]);

            $user->roles()->attach($request->roles);

            // Automatización: crear perfil de docente o estudiante según el rol asignado
            $roleNames = Rol::whereIn('id', $request->roles)->pluck('nombre')->toArray();

            if (in_array('DOCENTE', $roleNames)) {
                \App\Models\Docente::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'codigo_docente' => 'DOC-' . strtoupper(substr(uniqid(), -6)),
                        'genero_docente' => $request->genero ?? 'Masculino',
                        'foto_docente'   => 'default.png',
                        'estado_docente' => true,
                    ]
                );
            }

            if (in_array('ESTUDIANTE', $roleNames)) {
                \App\Models\Estudiante::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'codigo_estudiante' => 'EST-' . strtoupper(substr(uniqid(), -6)),
                        'genero_estudiante' => $request->genero ?? 'Masculino',
                        'foto_estudiante'   => 'images/default_user.png',
                        'email_estudiante'  => $request->email,
                        'estado_estudiante' => true,
                        'anho_curso_estudiante' => date('Y'),
                        'tipo_identificacion_estudiante' => 'TI',
                        'numero_identificacion_estudiante' => 'ID-' . strtoupper(substr(uniqid(), -6)),
                    ]
                );
            }
        });

        return redirect()->route('admin.usuarios.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El usuario ha sido creado correctamente.'
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'genero'   => 'nullable|string',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:rol,id'
        ]);

        DB::transaction(function() use ($request, $user) {
            $data = [
                'name'   => $request->name,
                'email'  => $request->email,
                'genero' => $request->genero,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->roles()->sync($request->roles);
        });

        return redirect()->route('admin.usuarios.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El usuario ha sido actualizado correctamente.'
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        // Evitar que el usuario se elimine a sí mismo
        if (auth()->id() === $user->id) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'No puedes eliminar tu propio usuario.'
            ]);
        }

        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Eliminado!',
            'text'  => 'El usuario ha sido eliminado correctamente.'
        ]);
    }
}
