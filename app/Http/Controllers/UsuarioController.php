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

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $usuarios = $query->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
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
