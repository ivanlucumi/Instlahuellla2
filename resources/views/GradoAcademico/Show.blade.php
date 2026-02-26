@extends('layouts.Administracion')

@section('title', 'Detalles del Grado: ' . $gradoAcademico->nombre_grado)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white">Grado: {{ $gradoAcademico->nombre_grado }} - {{ $gradoAcademico->bloque }}</h4>
                    <p class="text-muted mb-0">
                        <i class="fa fa-school me-1"></i> Sede: {{ $gradoAcademico->sede->nombre_sede ?? 'N/A' }} | 
                        <i class="fa fa-user-tie me-1"></i> Director: {{ $gradoAcademico->docente->user->name ?? 'N/A' }}
                    </p>
                </div>
                <a href="{{ route('admin.gradoacademico.index') }}" class="btn btn-warning">
                    <i class="fa fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Listado de Asignaturas -->
        <div class="col-sm-12 col-md-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0"><i class="fa fa-book me-2 text-primary"></i> Asignaturas del Grado</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Docente</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gradoAcademico->asignaturas as $asig)
                                <tr>
                                    <td>{{ $asig->nombre_asignatura }}</td>
                                    <td>
                                        @php
                                            $docente = $asig->docentes->firstWhere('id', $asig->pivot->docente_id);
                                        @endphp
                                        <small>{{ $docente ? $docente->name : 'No asignado' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('docente.asignatura.estudiantes', [$asig->id, $gradoAcademico->id]) }}" 
                                           class="btn btn-sm btn-outline-info" title="Ver calificaciones">
                                            <i class="fa fa-graduation-cap"></i> Notas
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">No hay asignaturas vinculadas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Listado de Estudiantes -->
        <div class="col-sm-12 col-md-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0"><i class="fa fa-users me-2 text-primary"></i> Estudiantes Matriculados</h5>
                    <span class="badge bg-primary">{{ $estudiantes->count() }} total</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Identificación</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->user->name }}</td>
                                    <td><small>{{ $estudiante->numero_identificacion_estudiante }}</small></td>
                                    <td class="text-center">
                                        @if($estudiante->estado_estudiante)
                                            <span class="badge bg-success small">Activo</span>
                                        @else
                                            <span class="badge bg-danger small">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">No hay estudiantes vinculados a este grado.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
