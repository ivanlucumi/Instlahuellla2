@extends('layouts.Administracion')

@section('title', 'Gestión de Acudientes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Acudientes Registrados</h4>
                <a href="{{ route('admin.acudiente.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Acudiente
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
                                <th scope="col">Email</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Parentesco</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($acudientes as $acudiente)
                                <tr>
                                    <th scope="row">{{ ($acudientes->currentPage() - 1) * $acudientes->perPage() + $loop->iteration }}</th>
                                    <td>{{ $acudiente->user->name ?? 'N/A' }}</td>
                                    <td>{{ $acudiente->user->email ?? 'N/A' }}</td>
                                    <td>{{ $acudiente->celular_acudiente }}</td>
                                    <td>{{ Str::limit($acudiente->direccion_acudiente, 30) }}</td>
                                    <td>{{ $acudiente->parentesco_acudiente }}</td>
                                    <td>
                                        <span class="badge {{ $acudiente->estado_acudiente ? 'bg-success' : 'bg-danger' }}">
                                            {{ $acudiente->estado_acudiente ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.acudiente.edit', $acudiente) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.acudiente.destroy', $acudiente) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este acudiente?');">
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
                                    <td colspan="8" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay acudientes registrados.
                                            <a href="{{ route('admin.acudiente.create') }}" class="alert-link">Crear el primer acudiente</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($acudientes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $acudientes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
