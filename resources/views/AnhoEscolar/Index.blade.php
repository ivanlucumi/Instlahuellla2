@extends('layouts.Administracion')

@section('title', 'Gestión de Año Escolar')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <form action="{{ route('admin.anhoescolar.index') }}" method="GET" class="row g-3 align-items-end">
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
                                   placeholder="Nombre del año escolar..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.anhoescolar.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.anhoescolar.create') }}" class="btn btn-primary">
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
                                <th scope="col">Nombre</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">Fin</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anhoEscolars as $anho)
                                <tr>
                                    <th scope="row">{{ ($anhoEscolars->currentPage() - 1) * $anhoEscolars->perPage() + $loop->iteration }}</th>
                                    <td>{{ $anho->nombre_anho_escolar }}</td>
                                    <td>{{ $anho->fecha_inicio_anho_escolar->format('d/m/Y') }}</td>
                                    <td>{{ $anho->fecha_fin_anho_escolar->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $anho->estado_anho_escolar ? 'bg-success' : 'bg-danger' }}">
                                            {{ $anho->estado_anho_escolar ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.anhoescolar.edit', $anho) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.anhoescolar.destroy', $anho) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este año escolar?');">
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
                                    <td colspan="6" class="text-center">No hay años escolares registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $anhoEscolars->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
