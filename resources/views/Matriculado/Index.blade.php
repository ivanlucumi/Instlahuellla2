@extends('layouts.Administracion')

@section('title', 'Gestión de Matrículas')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Matrículas Registradas</h4>
                <a href="{{ route('admin.matriculado.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nueva Matrícula
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
                                <th scope="col">Estudiante</th>
                                <th scope="col">Acudiente</th>
                                <th scope="col">Asignatura</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Año Escolar</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha Matrícula</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($matriculados as $matriculado)
                                <tr>
                                    <th scope="row">{{ ($matriculados->currentPage() - 1) * $matriculados->perPage() + $loop->iteration }}</th>
                                    <td>
                                        {{ $matriculado->estudiante->user->name ?? 'N/A' }}
                                        <br>
                                        <small class="text-muted">{{ $matriculado->estudiante->codigo_estudiante ?? '' }}</small>
                                    </td>
                                    <td>{{ $matriculado->acudiente->user->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $matriculado->asignatura->nombre_asignatura ?? 'N/A' }}
                                        <br>
                                        <span class="badge {{ $matriculado->asignatura->nivel_educativo == 'primaria' ? 'bg-info' : 'bg-success' }}">
                                            {{ ucfirst($matriculado->asignatura->nivel_educativo ?? '') }}
                                        </span>
                                    </td>
                                    <td>{{ $matriculado->grado->nombre_grado ?? 'N/A' }}</td>
                                    <td>{{ $matriculado->anhoEscolar->nombre_anho_escolar ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($matriculado->estado == 'activo') bg-success
                                            @elseif($matriculado->estado == 'inactivo') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($matriculado->estado) }}
                                        </span>
                                    </td>
                                    <td>{{ $matriculado->fecha_matricula?->format('d/m/Y') ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.matriculado.edit', $matriculado) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.matriculado.destroy', $matriculado) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta matrícula?');">
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
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay matrículas registradas.
                                            <a href="{{ route('admin.matriculado.create') }}" class="alert-link">Crear la primera matrícula</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($matriculados->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $matriculados->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
