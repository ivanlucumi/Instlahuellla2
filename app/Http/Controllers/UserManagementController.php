<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // Restricted to Rector, Admin and Superadmin
        $this->middleware(['auth', 'role_secure:RECTOR,SUPERADMIN,ADMIN']);
    }

    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            })
            // Search in related identifiers if necessary, but name/email is standard
            ->orWhereHas('estudiante', function($q) use ($search) {
                $q->where('numero_identificacion_estudiante', 'LIKE', "%$search%");
            })
            ->orWhereHas('docente', function($q) use ($search) {
                $q->where('codigo_docente', 'LIKE', "%$search%");
            });
        }

        $usuarios = $query->paginate(15)->appends($request->all());

        return view('admin.usuarios.gestion_claves', compact('usuarios'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Using direct model update, which triggers the 'hashed' cast
            $user->update([
                'password' => $request->new_password
            ]);

            return back()->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'Contraseña del usuario ' . $user->name . ' restablecida correctamente.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo restablecer la contraseña.'
            ]);
        }
    }
}
