@extends('layouts.Administracion')

@section('title', 'Gestión de Grados Académicos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Grados Académicos Registrados</h4>
                <a href="{{ route('admin.gradoacademico.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Grado
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
                                <th scope="col">Bloque</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Director</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grados as $grado)
                                <tr>
                                    <th scope="row">{{ ($grados->currentPage() - 1) * $grados->perPage() + $loop->iteration }}</th>
                                    <td>{{ $grado->nombre_grado }}</td>
                                    <td>{{ $grado->bloque }}</td>
                                    <td>{{ $grado->sede->nombre_sede ?? 'N/A' }}</td>
                                    <td>{{ $grado->docente->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $grado->estado_grado_academico ? 'bg-success' : 'bg-danger' }}">
                                            {{ $grado->estado_grado_academico ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.gradoacademico.edit', $grado) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.gradoacademico.destroy', $grado) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este grado académico?');">
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
                                            No hay grados académicos registrados.
                                            <a href="{{ route('admin.gradoacademico.create') }}" class="alert-link">Crear el primer grado</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($grados->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $grados->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
