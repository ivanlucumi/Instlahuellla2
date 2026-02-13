@extends('layouts.Administracion')

@section('title', 'Gestión de Asignaturas')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Asignaturas Registradas</h4>
                <a href="{{ route('admin.asignatura.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nueva Asignatura
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
                                <th scope="col">Nombre</th>
                                <th scope="col">Nivel Educativo</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Hilo</th>
                                <th scope="col">Docente</th>
                                <th scope="col">Créditos</th>
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
                                    <td>{{ $asignatura->sede->nombre_sede ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $asignatura->hilo->nombre_hilo ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $asignatura->docente->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $asignatura->creditos }}</span>
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
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
                        {{ $asignaturas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
