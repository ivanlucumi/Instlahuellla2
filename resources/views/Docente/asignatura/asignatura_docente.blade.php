@extends('layouts.Administracion')

@section('title', 'Mis Asignaturas')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-white">Mis Asignaturas</h4>
            <p class="text-muted">Seleccione una asignatura para ver el listado de estudiantes y gestionar calificaciones.</p>
        </div>
    </div>

    @if($asignaturas->isEmpty())
        <div class="alert alert-info">
            <i class="fa fa-info-circle me-2"></i> No tienes asignaturas asignadas en este momento.
        </div>
    @else
        <div class="row g-4">
            @foreach ($asignaturas as $asignatura)
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
                        <i class="fa fa-book fa-3x text-primary"></i>
                        <div class="ms-3 text-end">
                            <h6 class="mb-2 text-white">{{ $asignatura->nombre_asignatura }}</h6>
                            <p class="mb-2 badge bg-info">{{ $asignatura->hilo->nombre_hilo ?? 'N/A' }}</p>
                            <br>
                            <a href="{{ route('docente.asignatura.estudiantes', $asignatura->id) }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fa fa-users me-1"></i> Ver Estudiantes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
