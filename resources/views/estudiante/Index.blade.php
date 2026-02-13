@extends('layouts.Administracion')

@section('title', 'Gestión de Estudiantes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Estudiantes Registrados</h4>
                <a href="{{ route('admin.estudiante.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Estudiante
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
                                <th scope="col">Foto</th>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Acudiente</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="{{ asset($estudiante->foto_estudiante) }}" alt="" style="width: 40px; height: 40px;">
                                    </td>
                                    <td>{{ $estudiante->codigo_estudiante }}</td>
                                    <td>{{ $estudiante->user->name ?? 'N/A' }}</td>
                                    <td>{{ $estudiante->gradoAcademico->nombre_grado ?? 'N/A' }}</td>
                                    <td>{{ $estudiante->acudiente->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $estudiante->estado_estudiante ? 'bg-success' : 'bg-danger' }}">
                                            {{ $estudiante->estado_estudiante ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.estudiante.edit', $estudiante) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.estudiante.destroy', $estudiante) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
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
                                    <td colspan="7" class="text-center">No hay estudiantes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $estudiantes->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
