<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Acudiente;
use App\Mail\VerifyNewEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = null;
        $role = 'Usuario';

        if ($user->hasRol('DOCENTE')) {
            $profile = $user->docente;
            $role = 'Docente';
        } elseif ($user->hasRol('ESTUDIANTE')) {
            $profile = $user->estudiante;
            $role = 'Estudiante';
        } elseif ($user->hasRol('ACUDIENTE')) {
            $profile = $user->acudiente;
            $role = 'Acudiente';
        } elseif ($user->hasRol('RECTOR')) {
            $role = 'Rector';
        } elseif ($user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN')) {
            $role = 'Administrador';
        }

        return view('profile.edit', compact('user', 'profile', 'role'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'email',
                // Ensure the email is not already taken in the main email column (excluding current user)
                'unique:users,email,' . $user->id,
                // Also ensure it's not pending for another user in new_email column
                function ($attribute, $value, $fail) use ($user) {
                    $exists = User::where('new_email', $value)->where('id', '!=', $user->id)->exists();
                    if ($exists) {
                        $fail('Este correo ya está reservado para una verificación pendiente.');
                    }
                },
            ],
            'password' => 'nullable|min:8|confirmed',
        ];

        // Add role-specific rules
        if ($user->hasRol('DOCENTE')) {
            $rules['genero_docente'] = 'required|in:Masculino,Femenino,Otro';
        } elseif ($user->hasRol('ESTUDIANTE')) {
            $rules['telefono_estudiante'] = 'nullable|string|max:20';
            $rules['direccion_estudiante'] = 'nullable|string|max:255';
            $rules['genero_estudiante'] = 'required|in:Masculino,Femenino,Otro';
        } elseif ($user->hasRol('ACUDIENTE')) {
            $rules['celular_acudiente'] = 'nullable|string|max:20';
            $rules['direccion_acudiente'] = 'nullable|string|max:255';
            $rules['parentesco_acudiente'] = 'required|string|max:50';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $emailChanged = ($request->email !== $user->email);
            
            // Update User
            $user->name = $request->name;
            if ($request->filled('password')) {
                $user->password = $request->password; // Cast handles hashing
            }

            if ($emailChanged) {
                $user->new_email = $request->email;
                // Generate signed URL
                $verifyUrl = URL::signedRoute('profile.confirm-email', ['user' => $user->id, 'email' => $request->email], now()->addMinutes(60));
                Mail::to($request->email)->send(new VerifyNewEmail($user, $verifyUrl));
            }

            $user->save();

            // Update Specific Profiles
            if ($user->hasRol('DOCENTE') && $user->docente) {
                $user->docente->update([
                    'genero_docente' => $request->genero_docente,
                ]);
            } elseif ($user->hasRol('ESTUDIANTE') && $user->estudiante) {
                $user->estudiante->update([
                    'telefono_estudiante' => $request->telefono_estudiante,
                    'direccion_estudiante' => $request->direccion_estudiante,
                    'genero_estudiante' => $request->genero_estudiante,
                ]);
            } elseif ($user->hasRol('ACUDIENTE') && $user->acudiente) {
                $user->acudiente->update([
                    'celular_acudiente' => $request->celular_acudiente,
                    'direccion_acudiente' => $request->direccion_acudiente,
                    'parentesco_acudiente' => $request->parentesco_acudiente,
                ]);
            }

            DB::commit();

            $msg = 'Perfil actualizado correctamente.';
            if ($emailChanged) {
                $msg .= ' Se ha enviado un correo a ' . $request->email . ' para confirmar el cambio.';
            }

            return back()->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating profile: ' . $e->getMessage());
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al actualizar el perfil.'
            ]);
        }
    }

    public function confirmEmail(Request $request, User $user)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Enlace de confirmación inválido o expirado.');
        }

        if (!$user->new_email || $user->new_email !== $request->email) {
            abort(400, 'El correo a confirmar no coincide con la solicitud pendiente.');
        }

        $oldEmail = $user->email;
        $newEmail = $user->new_email;

        DB::beginTransaction();
        try {
            // 1. Update main User record
            $user->email = $newEmail;
            $user->new_email = null;
            $user->email_verified_at = now();
            $user->save();

            // 2. Sync with role-specific tables if they have redundant email fields
            if ($user->hasRol('ESTUDIANTE') && $user->estudiante) {
                // Estudiante model has 'email_estudiante'
                $user->estudiante->update(['email_estudiante' => $newEmail]);
            }

            DB::commit();

            return redirect()->route('home')->with('swal', [
                'icon' => 'success',
                'title' => 'Correo Confirmado',
                'text' => 'Tu dirección de correo ha sido actualizada. A partir de ahora deberás iniciar sesión con: ' . $newEmail
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error confirming email: ' . $e->getMessage());
            return redirect()->route('home')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al procesar la confirmación.'
            ]);
        }
    }
}
