@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Criterios de Evaluación - Grado Cero</h6>
                    <a href="{{ route('admin.grado-cero.criterios.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Nuevo Criterio
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Asignatura</th>
                                <th scope="col">Criterio / Logro</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criterios as $criterio)
                            <tr>
                                <td>{{ $criterio->asignatura->nombre_asignatura }}</td>
                                <td>{{ $criterio->nombre_criterio }}</td>
                                <td>
                                    <span class="badge {{ $criterio->estado ? 'bg-success' : 'bg-danger' }}">
                                        {{ $criterio->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.grado-cero.criterios.edit', $criterio->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.grado-cero.criterios.destroy', $criterio->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('¿Está seguro?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $criterios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
