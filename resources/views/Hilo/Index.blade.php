@extends('layouts.Administracion')

@section('title', 'Gestión de Hilos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Hilos Registrados</h4>
                <a href="{{ route('admin.hilo.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Hilo
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
                                <th scope="col">Nombre del Hilo</th>
                                <th scope="col">Abreviatura</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hilos as $hilo)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $hilo->nombre_hilo }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $hilo->abreviatura }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $hilo->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($hilo->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.hilo.edit', $hilo) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.hilo.destroy', $hilo) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este hilo?');">
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
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay hilos registrados.
                                            <a href="{{ route('admin.hilo.create') }}" class="alert-link">Crear el primer hilo</a>
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
