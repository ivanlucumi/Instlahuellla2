@extends('layouts.Administracion')

@section('title', 'Gestión de Grados')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-dark fw-bold mb-1">Gestión de Grados y Cursos</h4>
            <p class="text-muted small">Seleccione un grado para ver el listado de clases y estudiantes.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($grados as $grado)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded p-3 text-primary me-3">
                                <i class="fa fa-users fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $grado->nombre_grado }}</h6>
                                <small class="text-muted">ID: {{ $grado->id }}</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-xs fw-bold text-uppercase text-muted mb-2 d-block">Asignaturas Vinculadas</label>
                            @if ($asignaturas->isEmpty())
                                <span class="badge bg-light text-muted border">Sin asignaturas</span>
                            @else
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($asignaturas as $asignatura)
                                        <span class="badge bg-light text-dark border">{{ $asignatura->nombre_asignatura }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('docente.listado.clases', $grado->id) }}" 
                           class="btn btn-outline-primary w-100 rounded-pill py-2">
                            <i class="fa fa-list me-2"></i> Listado de Clases
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border shadow-sm text-center py-5">
                    <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No hay grados asignados a su perfil en este momento.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .text-xs { font-size: 0.75rem; }
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
</style>
@endsection
