@extends('layouts.Administracion')

@section('title', 'Gestión de Periodos Académicos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <form action="{{ route('admin.periodoacademico.index') }}" method="GET" class="row g-3 align-items-end">
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
                                   placeholder="Nombre del periodo..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.periodoacademico.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.periodoacademico.create') }}" class="btn btn-primary">
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
                                <th scope="col">Año Escolar</th>
                                <th scope="col">Periodo</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">Fin</th>
                                <th scope="col">Peso (%)</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($periodoAcademicos as $periodo)
                                <tr>
                                    <th scope="row">{{ ($periodoAcademicos->currentPage() - 1) * $periodoAcademicos->perPage() + $loop->iteration }}</th>
                                    <td>{{ $periodo->anhoEscolar->nombre_anho_escolar ?? 'N/A' }}</td>
                                    <td>{{ $periodo->nombre_periodo }}</td>
                                    <td>{{ $periodo->fecha_inicio->format('d/m/Y') }}</td>
                                    <td>{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-primary">{{ $periodo->porcentaje_periodo }}%</span></td>
                                    <td>
                                        <span class="badge {{ $periodo->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($periodo->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.periodoacademico.edit', $periodo) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.periodoacademico.destroy', $periodo) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este periodo académico?');">
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
                                    <td colspan="8" class="text-center">No hay periodos académicos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $periodoAcademicos->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
