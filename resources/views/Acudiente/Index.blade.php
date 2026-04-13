@extends('layouts.Administracion')

@section('title', 'Gestión de Acudientes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-warning">
                <form action="{{ route('admin.acudiente.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 registros</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 registros</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Género</label>
                        <select name="genero" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Cualquiera</option>
                            <option value="Masculino" {{ request('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ request('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="text-white-50 small mb-1">Búsqueda rápida</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                                   placeholder="Nombre, email o celular..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.acudiente.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        @if(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']))
                        <a href="{{ route('admin.acudiente.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Nuevo Acudiente
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Parentesco</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($acudientes as $acudiente)
                                <tr>
                                    <th scope="row">{{ ($acudientes->currentPage() - 1) * $acudientes->perPage() + $loop->iteration }}</th>
                                    <td>{{ $acudiente->user->name ?? 'N/A' }}</td>
                                    <td>{{ $acudiente->user->email ?? 'N/A' }}</td>
                                    <td>{{ $acudiente->celular_acudiente }}</td>
                                    <td>{{ Str::limit($acudiente->direccion_acudiente, 30) }}</td>
                                    <td>{{ $acudiente->parentesco_acudiente }}</td>
                                    <td>
                                        <span class="badge {{ $acudiente->estado_acudiente ? 'bg-success' : 'bg-danger' }}">
                                            {{ $acudiente->estado_acudiente ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'SECRETARIO']))
                                        <a href="{{ route('admin.acudiente.edit', $acudiente) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endif
                                        
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.acudiente.destroy', $acudiente) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este acudiente?');">
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
                                    <td colspan="8" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay acudientes registrados.
                                            <a href="{{ route('admin.acudiente.create') }}" class="alert-link">Crear el primer acudiente</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($acudientes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $acudientes->appends(request()->all())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
