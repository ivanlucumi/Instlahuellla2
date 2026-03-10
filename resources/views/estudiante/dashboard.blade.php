@extends('layouts.Administracion')

@section('title', 'Mi Dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <!-- Información del Estudiante -->
        <div class="col-sm-12 col-xl-4">
            <div class="bg-secondary rounded h-100 p-4 text-center">
                <img src="{{ asset($estudiante->foto_estudiante) }}" alt="Foto" class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                <h5 class="mb-1 text-white">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-3">{{ $estudiante->codigo_estudiante }}</p>
                <div class="d-flex justify-content-around">
                    <div>
                        <h6 class="mb-0 text-white">Género</h6>
                        <small>{{ $estudiante->genero_estudiante }}</small>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white">Estado</h6>
                        <span class="badge {{ $estudiante->estado_estudiante ? 'bg-success' : 'bg-danger' }}">
                            {{ $estudiante->estado_estudiante ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Académica Actual -->
        <div class="col-sm-12 col-xl-8">
            <div class="bg-secondary rounded h-100 p-4">
                <h5 class="mb-4 text-white">Información Académica Atual</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Año Escolar</label>
                        <h6 class="text-white">{{ $ultimaMatricula->anhoEscolar->nombre_anho_escolar ?? 'N/A' }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Grado Académico</label>
                        <h6 class="text-white">{{ $ultimaMatricula->grado->nombre_grado ?? 'N/A' }} - {{ $ultimaMatricula->grado->bloque ?? '' }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Sede</label>
                        <h6 class="text-white">{{ $ultimaMatricula->grado->sede->nombre_sede ?? 'N/A' }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Acudiente</label>
                        <h6 class="text-white">{{ $ultimaMatricula->acudiente->user->name ?? 'N/A' }}</h6>
                    </div>
                </div>
                <div class="mt-2">
                    <a href="{{ route('estudiante.acudiente.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-user-edit me-1"></i> Actualizar Info Acudiente
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de Notas -->
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="mb-0 text-white">Resumen de Calificaciones ({{ $ultimaMatricula->anhoEscolar->nombre_anho_escolar ?? '' }})</h5>
                    <a href="{{ route('estudiante.history') }}" class="btn btn-outline-primary btn-sm">Ver Historial Completo</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th scope="col">Asignatura</th>
                                <th scope="col">P1</th>
                                <th scope="col">P2</th>
                                <th scope="col">P3</th>
                                <th scope="col">P4</th>
                                <th scope="col">Definitiva</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notasActuales as $nota)
                                <tr>
                                    <td>{{ $nota->asignatura->nombre_asignatura }}</td>
                                    <td>{{ $nota->nota1 ?? '-' }}</td>
                                    <td>{{ $nota->nota2 ?? '-' }}</td>
                                    <td>{{ $nota->nota3 ?? '-' }}</td>
                                    <td>{{ $nota->nota4 ?? '-' }}</td>
                                    <td class="fw-bold {{ ($nota->nota_definitiva >= 3) ? 'text-success' : 'text-danger' }}">
                                        {{ $nota->nota_definitiva ?? '-' }}
                                    </td>
                                    <td>
                                        @if($nota->nota_definitiva !== null)
                                            <span class="badge {{ ($nota->nota_definitiva >= 3) ? 'bg-success' : 'bg-danger' }}">
                                                {{ ($nota->nota_definitiva >= 3) ? 'Aprobada' : 'Reprobada' }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">En curso</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            No se han registrado calificaciones para este periodo.
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