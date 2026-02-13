@extends('layouts.Administracion')

@section('title', 'Gestión de Año Escolar')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-white">Años Escolares Registrados</h4>
                <a href="{{ route('admin.anhoescolar.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Nuevo Año
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
                                <th scope="col">Inicio</th>
                                <th scope="col">Fin</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anhos as $anho)
                                <tr>
                                    <th scope="row">{{ ($anhos->currentPage() - 1) * $anhos->perPage() + $loop->iteration }}</th>
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
                {{ $anhos->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
