@extends('layouts.Administracion')

@section('title', 'Mis Asignaturas')

@section('content')
<div class="container-fluid pt-4 px-4">
    {{-- Hero Section for Docentes --}}
    <div class="row g-4 mb-4 dashboard-animate-fade-in">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 p-md-5 shadow-lg position-relative overflow-hidden border-start border-5 border-success">
                <div class="row align-items-center">
                    <div class="col-lg-8 position-relative" style="z-index: 2;">
                        <span class="badge bg-success mb-2 px-3 py-2">Panel Docente</span>
                        <h1 class="display-5 fw-bold text-white mb-2">
                            Hola, <span class="text-success">{{ auth()->user()->name }}</span>
                        </h1>
                        <p class="lead text-white-50 mb-0">
                            @if($isSuperAdmin) Estás visualizando todas las asignaciones de la institución.
                            @elseif($isDirector) Supervisando el progreso académico de tu grado asignado.
                            @else Tienes {{ $assignments->count() }} asignaturas bajo tu responsabilidad este periodo. @endif
                        </p>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <img src="{{ asset('panelAdmin/img/institutional_hero.png') }}" 
                             alt="Docente" 
                             class="img-fluid rounded-3 shadow-sm dashboard-animate-slide-right"
                             style="max-height: 180px; object-fit: cover; opacity: 0.8; filter: grayscale(0.2);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 align-items-center dashboard-animate-fade-in" style="animation-delay: 0.2s">
        <div class="col-md-6">
            <h4 class="text-white fw-bold mb-1">
                <i class="fa fa-book-reader me-2 text-success"></i>Gestión de Clases
            </h4>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="badge bg-dark text-white-50 p-2 border border-secondary shadow-sm">
                <i class="fa fa-calendar-alt me-1 text-success"></i> Año Lectivo {{ date('Y') }}
            </div>
        </div>
    </div>

    @if($groupedAssignments->isEmpty())
        <div class="alert bg-dark text-white-50 border-secondary shadow-sm dashboard-animate-slide-up">
            <i class="fa fa-info-circle me-2 text-info"></i> {{ $isSuperAdmin ? 'No hay materias asignadas en el sistema todavía.' : 'No tienes materias asignadas en ningún grado en este momento.' }}
        </div>
    @else
        @foreach($groupedAssignments as $gradoNombre => $materias)
            <div class="mb-5 dashboard-animate-fade-in">
                <h3 class="text-success border-bottom border-success pb-2 mb-4 fw-bold">
                    <i class="fa fa-layer-group me-2"></i> {{ $gradoNombre }}
                </h3>
                <div class="row g-4">
                    @foreach ($materias as $index => $asig)
                        <div class="col-sm-6 col-xl-4 dashboard-animate-slide-up" style="animation-delay: {{ 0.1 + (($index % 10) * 0.1) }}s">
                            <div class="bg-secondary rounded shadow-sm h-100 overflow-hidden hover-elevate border border-transparent transition-all">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="p-3 bg-dark rounded shadow-sm border border-success border-opacity-25">
                                            <i class="fa fa-book fa-2x text-success"></i>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ $asig->hilo_nombre }}</span>
                                    </div>
                                    
                                    <h5 class="text-white fw-bold mb-3">{!! $asig->nombre_asignatura !!}</h5>
                                    
                                    <div class="mb-4 space-y-2">
                                        <div class="d-flex align-items-center text-white-50 small mb-2">
                                            <i class="fa fa-graduation-cap me-3 text-success"></i>
                                            <strong>Grado:</strong> <span class="ms-2 text-white">{{ $asig->grado_nombre }}</span>
                                        </div>
                                        @if($isSuperAdmin || $isDirector)
                                            <div class="d-flex align-items-center text-white-50 small">
                                                <i class="fa fa-user-tie me-3 text-warning"></i>
                                                <strong>Docente:</strong> <span class="ms-2 text-white">{{ $asig->docente_nombre }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if(isset($asig->is_virtual_grado_cero) && $asig->is_virtual_grado_cero)
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('admin.criterio-grado-cero.index') }}" class="btn btn-outline-warning rounded-pill py-2 shadow-sm dashboard-btn-hover">
                                                <i class="fa fa-list me-2"></i> Criterios de Evaluación
                                            </a>
                                            <a href="{{ route('admin.calificacion-grado-cero.index') }}" class="btn btn-outline-success rounded-pill py-2 shadow-sm dashboard-btn-hover">
                                                <i class="fa fa-pencil-alt me-2"></i> Calificar Transición
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('docente.asignatura.estudiantes', [$asig->id, $asig->grado_id]) }}" 
                                           class="btn btn-outline-success w-100 rounded-pill py-2 dashboard-btn-hover shadow-sm">
                                            <i class="fa fa-pencil-alt me-2"></i> {{ ($isSuperAdmin || $isDirector) ? 'Ver Detalles' : 'Calificar Estudiantes' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    /* Animaciones */
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes slideRight { from { transform: translateX(-20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    .dashboard-animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .dashboard-animate-slide-up { animation: slideUp 0.6s ease-out forwards; opacity: 0; }
    .dashboard-animate-slide-right { animation: slideRight 0.8s ease-out forwards; }

    .transition-all { transition: all 0.3s ease; }
    
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.4) !important;
        border-color: rgba(var(--bs-success-rgb), 0.3) !important;
    }

    .dashboard-btn-hover:hover {
        background-color: var(--bs-success);
        color: white !important;
    }

    .border-transparent { border-color: transparent; }
</style>
@endsection
