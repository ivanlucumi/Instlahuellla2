@extends('layouts.Administracion')

@section('title', 'Gestión de Usuarios')

@section('content')

<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-white">Usuarios del Sistema</h4>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Nuevo Usuario
            </a>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="bg-secondary rounded p-4">
            <form action="{{ route('admin.usuarios.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label text-white-50 small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 registros</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 registros</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label text-white-50 small mb-1">Filtrar por Rol</label>
                        <select name="rol_id" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Todos los roles</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id }}" {{ request('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-white-50 small mb-1">Género</label>
                        <select name="genero" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Cualquiera</option>
                            <option value="Masculino" {{ request('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ request('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-white-50 small mb-1">Búsqueda rápida</label>
                        <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                               placeholder="Nombre o email..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-search me-1"></i>
                            </button>
                            @if(request()->anyFilled(['search', 'rol_id', 'genero', 'per_page']))
                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-light">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover text-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Género</th>
                <th scope="col">Roles</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <th scope="row">{{ $usuario->id }}</th>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->genero ?? 'N/A' }}</td>
                    <td>
                        @foreach($usuario->roles as $rol)
                            <span class="badge bg-info text-dark">{{ $rol->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" 
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        
                        @if(auth()->user()->hasRol('SUPERADMIN') && auth()->id() !== $usuario->id)
                            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" 
                                  method="POST" 
                                  class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        <div class="alert alert-warning mb-0">
                            <i class="fa fa-exclamation-triangle me-2"></i>
                            No se encontraron usuarios.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $usuarios->appends(['search' => request('search')])->links() }}
</div>

@endsection

@section('scripts')
<script>
    $('.form-delete').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
    });
</script>
@endsection
