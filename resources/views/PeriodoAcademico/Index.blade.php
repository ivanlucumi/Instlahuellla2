@extends('layouts.Administracion')

@section('title', 'Gestión de Periodos Académicos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Periodos Académicos Registrados</h4>
                <a href="{{ route('admin.periodoacademico.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Periodo
                </a>
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
                            @forelse($periodos as $periodo)
                                <tr>
                                    <th scope="row">{{ ($periodos->currentPage() - 1) * $periodos->perPage() + $loop->iteration }}</th>
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
                {{ $periodos->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
