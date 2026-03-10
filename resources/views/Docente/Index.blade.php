@extends('layouts.Administracion')

@section('title', 'Gestión de Docentes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Docentes Registrados</h4>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control form-control-sm me-3 search-table" placeholder="Buscar docente..." style="width: 200px;">
                    <a href="{{ route('admin.docente.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Nuevo Docente
                    </a>
                </div>
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
                                <th scope="col">Foto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Código</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($docentes as $docente)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        @if($docente->foto_docente && $docente->foto_docente !== 'default.png')
                                            <img src="{{ asset('storage/' . $docente->foto_docente) }}" 
                                                 alt="Foto" 
                                                 class="rounded-circle" 
                                                 width="40" 
                                                 height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fa fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $docente->user->name ?? 'N/A' }}</td>
                                    <td>{{ $docente->user->email ?? 'N/A' }}</td>
                                    <td>{{ $docente->codigo_docente }}</td>
                                    <td>
                                        <span class="badge {{ $docente->estado_docente ? 'bg-success' : 'bg-danger' }}">
                                            {{ $docente->estado_docente ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.docente.edit', $docente) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.docente.destroy', $docente) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este docente?');">
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
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay docentes registrados.
                                            <a href="{{ route('admin.docente.create') }}" class="alert-link">Crear el primer docente</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
