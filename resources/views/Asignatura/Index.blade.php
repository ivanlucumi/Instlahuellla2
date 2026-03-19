@extends('layouts.Administracion')

@section('title', 'Gestión de Asignaturas')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-info">
                <form action="{{ route('admin.asignatura.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 registros</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 registros</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="text-white-50 small mb-1">Hilo</label>
                        <select name="hilo_id" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Todos los Hilos</option>
                            @foreach($hilos as $hilo)
                                <option value="{{ $hilo->id }}" {{ request('hilo_id') == $hilo->id ? 'selected' : '' }}>{{ $hilo->nombre_hilo }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Nivel</label>
                        <select name="nivel_educativo" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="primaria" {{ request('nivel_educativo') == 'primaria' ? 'selected' : '' }}>Primaria</option>
                            <option value="secundaria" {{ request('nivel_educativo') == 'secundaria' ? 'selected' : '' }}>Secundaria</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="text-white-50 small mb-1">Búsqueda rápida</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                                   placeholder="Nombre de asignatura..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.asignatura.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.asignatura.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Nueva
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
                                <th scope="col">Nombre</th>
                                <th scope="col">Nivel Educativo</th>
                                <th scope="col">Hilo</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asignaturas as $asignatura)
                                <tr>
                                    <th scope="row">{{ ($asignaturas->currentPage() - 1) * $asignaturas->perPage() + $loop->iteration }}</th>
                                    <td>{{ $asignatura->nombre_asignatura }}</td>
                                    <td>
                                        <span class="badge {{ $asignatura->nivel_educativo == 'primaria' ? 'bg-info' : 'bg-success' }}">
                                            {{ ucfirst($asignatura->nivel_educativo) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $asignatura->hilo->nombre_hilo ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @forelse($asignatura->grados as $g)
                                            <span class="badge bg-dark">{{ $g->nombre_grado }} ({{ $g->bloque }})</span>
                                        @empty
                                            <span class="badge bg-secondary">General</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <span class="badge {{ $asignatura->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($asignatura->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.asignatura.edit', $asignatura) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.asignatura.destroy', $asignatura) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
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
                                            No hay asignaturas registradas.
                                            <a href="{{ route('admin.asignatura.create') }}" class="alert-link">Crear la primera asignatura</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($asignaturas->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $asignaturas->appends(request()->all())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
