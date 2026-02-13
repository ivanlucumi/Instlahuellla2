@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Gestión de Notas</h6>
                    <a href="{{ route('admin.notas.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Nueva Nota
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">ID</th>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Asignatura</th>
                                <th scope="col">Período</th>
                                <th scope="col">Nota</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notas as $nota)
                                <tr>
                                    <td>{{ $nota->id }}</td>
                                    <td>{{ $nota->estudiante->user->name ?? 'N/A' }}</td>
                                    <td>{{ $nota->asignatura->nombre_asignatura ?? 'N/A' }}</td>
                                    <td>{{ $nota->periodoAcademico->nombre_periodo ?? 'N/A' }}</td>
                                    <td>{{ $nota->nota }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.notas.edit', $nota->id) }}" 
                                               class="btn btn-sm btn-warning me-2"
                                               title="Editar">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.notas.destroy', $nota->id) }}" 
                                                  method="POST" 
                                                  class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Está seguro de eliminar esta nota?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay notas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $notas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
