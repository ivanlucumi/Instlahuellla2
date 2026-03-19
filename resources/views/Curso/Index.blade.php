@extends('layouts.Administracion')

@section('title', 'Gestión de Cursos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <form action="{{ route('admin.curso.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 registros</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                        </select>
                    </div>
                    
                    <div class="col-md-7">
                        <label class="text-white-50 small mb-1">Búsqueda rápida</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                                   placeholder="Nombre del curso..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.curso.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.curso.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Nuevo
                        </a>
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
                                <th scope="col">Nombre del Curso</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cursos as $curso)
                                <tr>
                                    <th scope="row">{{ ($cursos->currentPage() - 1) * $cursos->perPage() + $loop->iteration }}</th>
                                    <td>{{ $curso->nombre_curso }}</td>
                                    <td>{{ Str::limit($curso->descripcion, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $curso->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($curso->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.curso.edit', $curso) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.curso.destroy', $curso) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay cursos registrados.
                                            <a href="{{ route('admin.curso.create') }}" class="alert-link">Crear el primer curso</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $cursos->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
