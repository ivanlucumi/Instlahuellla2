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

    @if($assignments->isEmpty())
        <div class="alert alert-info">
            <i class="fa fa-info-circle me-2"></i> No tienes materias asignadas en ningún grado en este momento.
        </div>
    @else
        <div class="row g-4">
            @foreach ($assignments as $asig)
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100 border-start border-primary border-4">
                        <i class="fa fa-book fa-3x text-primary opacity-50"></i>
                        <div class="ms-3 text-end">
                            <h6 class="mb-1 text-white">{{ $asig->nombre_asignatura }}</h6>
                            <p class="mb-2 text-primary small fw-bold"><i class="fa fa-users me-1"></i>{{ $asig->grado_nombre }}</p>
                            <span class="badge bg-dark-info border border-info mb-3">{{ $asig->hilo_nombre }}</span>
                            <br>
                            <a href="{{ route('docente.asignatura.estudiantes', [$asig->id, $asig->grado_id]) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit me-1"></i> Calificar Grupo
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
