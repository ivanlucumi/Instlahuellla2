<?php

namespace App\Http\Controllers;

use App\Models\Acudiente;
use Illuminate\Http\Request;

class AcudienteController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']) || $user->isGradeDirector(), 403, 'No tiene permisos para ver los acudientes.');

        $query = Acudiente::with('user')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                })->orWhere('celular_acudiente', 'LIKE', "%$search%");
            });
        }

        if ($request->filled('genero')) {
            $query->where('genero_acudiente', $request->genero);
        }

        $perPage = $request->get('per_page', 15);
        $acudientes = $query->paginate($perPage)->appends($request->all());

        return view('Acudiente.Index', compact('acudientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para crear registros. Solo roles directivos pueden hacerlo.');

        $usuarios = \App\Models\User::whereDoesntHave('acudiente')->orderBy('name')->get();
        return view('Acudiente.Create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|string|email|max:255|unique:users',
            'celular_acudiente'    => 'required|string|max:20',
            'direccion_acudiente'  => 'required|string|max:255',
            'genero_acudiente'     => 'required|string',
            'parentesco_acudiente' => 'required|string|max:100',
            'estado_acudiente'     => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request) {
            // 1. Crear Usuario
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => \Hash::make('Temporal123'),
                'genero'   => $request->genero_acudiente,
            ]);

            // 2. Asignar Rol ACUDIENTE
            $rolAcudiente = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
            if ($rolAcudiente) {
                $user->roles()->attach($rolAcudiente->id);
            }

            // 3. Crear Acudiente
            Acudiente::create([
                'user_id'              => $user->id,
                'celular_acudiente'    => $request->celular_acudiente,
                'direccion_acudiente'  => $request->direccion_acudiente,
                'genero_acudiente'     => $request->genero_acudiente,
                'parentesco_acudiente' => $request->parentesco_acudiente,
                'estado_acudiente'     => $request->has('estado_acudiente') ? 1 : 0,
            ]);
        });

        return redirect()->route('admin.acudiente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'El acudiente y su usuario fueron registrados correctamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Acudiente $acudiente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acudiente $acudiente)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        return view('Acudiente.Edit', compact('acudiente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acudiente $acudiente)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|string|email|max:255|unique:users,email,' . $acudiente->user_id,
            'password'             => 'nullable|string|min:8',
            'celular_acudiente'    => 'required|string|max:20',
            'direccion_acudiente'  => 'required|string|max:255',
            'genero_acudiente'     => 'required|string',
            'parentesco_acudiente' => 'required|string|max:100',
            'estado_acudiente'     => 'nullable|boolean',
        ]);

        \DB::transaction(function() use ($request, $acudiente) {
            // 1. Actualizar Usuario
            $userData = [
                'name'   => $request->name,
                'email'  => $request->email,
                'genero' => $request->genero_acudiente,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = \Hash::make($request->password);
            }
            
            $acudiente->user->update($userData);

            // 2. Actualizar Acudiente
            $acudiente->update([
                'celular_acudiente'    => $request->celular_acudiente,
                'direccion_acudiente'  => $request->direccion_acudiente,
                'genero_acudiente'     => $request->genero_acudiente,
                'parentesco_acudiente' => $request->parentesco_acudiente,
                'estado_acudiente'     => $request->has('estado_acudiente') ? 1 : 0,
            ]);
        });

        return redirect()->route('admin.acudiente.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Proceso exitoso!',
            'text'  => 'El acudiente y su usuario de acceso fueron actualizados correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acudiente $acudiente)
    {
        abort_unless(auth()->user()->hasRol('SUPERADMIN'), 403, 'Solo el Súper Administrador puede eliminar registros.');

        $acudiente->delete();

        return redirect()->route('admin.acudiente.index')->with('swal', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El acudiente fue eliminado correctamente.'
        ]);
    }

    public function storeQuick(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO', 'DIRECTOR']), 403, 'No tiene permisos para modificar estos datos. Solo roles directivos pueden hacerlo.');

        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|string|email|max:255|unique:users',
            'celular_acudiente'    => 'required|string|max:20',
            'parentesco_acudiente' => 'required|string|max:100',
        ]);

        try {
            return \DB::transaction(function() use ($request) {
                // 1. Crear Usuario
                $user = \App\Models\User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => \Hash::make('Temporal123'),
                    'genero'   => 'no definido',
                ]);

                // 2. Asignar Rol ACUDIENTE
                $rolAcudiente = \App\Models\Rol::where('nombre', 'ACUDIENTE')->first();
                if ($rolAcudiente) {
                    $user->roles()->attach($rolAcudiente->id);
                }

                // 3. Crear Acudiente
                $acudiente = Acudiente::create([
                    'user_id'              => $user->id,
                    'celular_acudiente'    => $request->celular_acudiente,
                    'direccion_acudiente'  => 'N/A',
                    'genero_acudiente'     => 'no definido',
                    'parentesco_acudiente' => $request->parentesco_acudiente,
                    'estado_acudiente'     => 1,
                ]);

                return response()->json([
                    'id' => $acudiente->id,
                    'text' => $user->name . ' (' . $acudiente->parentesco_acudiente . ')',
                    'message' => 'Acudiente creado exitosamente'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el acudiente: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $acudientes = Acudiente::with('user')->get()->map(function($a) {
            return [
                'id' => $a->id,
                'text' => ($a->user->name ?? 'Sin nombre') . ' - ' . $a->parentesco_acudiente
            ];
        });
        return response()->json($acudientes);
    }

    public function buscarPorDocumento(Request $request)
    {
        $documento = $request->query('documento');
        
        if (!$documento) {
            return response()->json(['encontrado' => false], 400);
        }

        $acudiente = Acudiente::with('user')->where('id_documento', $documento)->first();

        if ($acudiente) {
            return response()->json([
                'encontrado' => true,
                'nombre'     => $acudiente->user->name ?? '',
                'celular'    => $acudiente->celular_acudiente ?? '',
                'parentesco' => $acudiente->parentesco_acudiente ?? 'Acudiente'
            ]);
        }

        return response()->json(['encontrado' => false]);
    }
}
