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
    <div class="col-md-6">
        <form action="{{ route('admin.usuarios.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control bg-dark border-0 me-2 text-white" 
                   placeholder="Buscar por nombre o email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary ms-2">
                    <i class="fa fa-times"></i>
                </a>
            @endif
        </form>
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
                        
                        @if(auth()->id() !== $usuario->id)
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
