@extends('layouts.Administracion')

@section('title', 'Mi Dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    {{-- Hero Section for Students --}}
    <div class="row g-4 mb-4 dashboard-animate-fade-in">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 p-md-5 shadow-lg position-relative overflow-hidden border-start border-5 border-info">
                <div class="row align-items-center">
                    <div class="col-lg-8 position-relative" style="z-index: 2;">
                        <span class="badge bg-info mb-2 px-3 py-2 text-dark fw-bold">Panel del Estudiante</span>
                        <h1 class="display-5 fw-bold text-white mb-2">
                            Hola, <span class="text-info">{{ auth()->user()->name }}</span>
                        </h1>
                        <p class="lead text-white-50 mb-4">
                            Sigue tu progreso académico y mantente al día con tus actividades escolares en <span class="text-info fw-bold">{{ $institucion->nombre_institucion ?? 'la institución' }}</span>.
                        </p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-dark border border-secondary p-2">
                                <i class="fa fa-calendar-alt text-info me-2"></i>{{ $ultimaMatricula->anhoEscolar->nombre_anho_escolar ?? date('Y') }}
                            </span>
                            <span class="badge bg-dark border border-secondary p-2">
                                <i class="fa fa-graduation-cap text-info me-2"></i>{{ $ultimaMatricula->grado->nombre_grado ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <img src="{{ asset('panelAdmin/img/institutional_hero.png') }}" 
                             alt="Student" 
                             class="img-fluid rounded-3 shadow-lg dashboard-animate-slide-right"
                             style="max-height: 200px; object-fit: cover; opacity: 0.7; filter: blur(0.5px) grayscale(0.2);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Perfil Estudiante -->
        <div class="col-sm-12 col-xl-4 dashboard-animate-slide-up" style="animation-delay: 0.2s">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm hover-elevate transition-all border border-transparent">
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <img src="{{ asset($estudiante->foto_estudiante) }}" alt="Foto" class="rounded-circle shadow-sm border border-3 border-info p-1" width="120" height="120" style="object-fit: cover;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-2 shadow-sm"></div>
                    </div>
                    <h5 class="mt-3 mb-1 text-white fw-bold">{{ Auth::user()->name }}</h5>
                    <p class="text-info small fw-bold mb-3">{{ $estudiante->codigo_estudiante }}</p>
                </div>
                
                <div class="space-y-3">
                    <div class="d-flex justify-content-between p-2 bg-dark rounded bg-opacity-50">
                        <span class="text-white-50 small">Género</span>
                        <span class="text-white small">{{ $estudiante->genero_estudiante }}</span>
                    </div>
                    <div class="d-flex justify-content-between p-2 bg-dark rounded bg-opacity-50">
                        <span class="text-white-50 small">Sede</span>
                        <span class="text-white small">{{ $ultimaMatricula->grado->sede->nombre_sede ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between p-2 bg-dark rounded bg-opacity-50 align-items-center">
                        <span class="text-white-50 small">Acudiente</span>
                        <span class="text-white small text-end" style="max-width: 150px;">{{ $ultimaMatricula->acudiente->user->name ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('estudiante.acudiente.edit') }}" class="btn btn-outline-info w-100 rounded-pill btn-sm py-2 dashboard-btn-hover">
                        <i class="fa fa-user-edit me-2"></i>Actualizar Acudiente
                    </a>
                </div>
            </div>
        </div>

        <!-- Resumen de Notas -->
        <div class="col-sm-12 col-xl-8 dashboard-animate-slide-up" style="animation-delay: 0.4s">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm border border-transparent">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="mb-0 text-white fw-bold">
                        <i class="fa fa-star text-warning me-2"></i>Calificaciones Recientes
                    </h5>
                    <a href="{{ route('estudiante.history') }}" class="text-info small text-decoration-none hover-underline">
                        Ver Historial Completo <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
                
                <div class="table-responsive text-nowrap">
                    <table class="table table-dark table-hover border-secondary">
                        <thead class="bg-dark bg-opacity-50">
                            <tr class="text-info small uppercase text-opacity-75">
                                <th>Asignatura</th>
                                <th class="text-center">P1</th>
                                <th class="text-center">P2</th>
                                <th class="text-center">P3</th>
                                <th class="text-center">P4</th>
                                <th class="text-center">Definitiva</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse($notasActuales as $nota)
                                <tr>
                                    <td class="fw-bold">{{ $nota->asignatura->nombre_asignatura }}</td>
                                    <td class="text-center text-white-50">{{ $nota->nota1 ?? '-' }}</td>
                                    <td class="text-center text-white-50">{{ $nota->nota2 ?? '-' }}</td>
                                    <td class="text-center text-white-50">{{ $nota->nota3 ?? '-' }}</td>
                                    <td class="text-center text-white-50">{{ $nota->nota4 ?? '-' }}</td>
                                    <td class="text-center fw-bold {{ ($nota->nota_definitiva >= 3) ? 'text-success' : 'text-danger' }}">
                                        {{ $nota->nota_definitiva ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        @if($nota->nota_definitiva !== null)
                                            <span class="badge {{ ($nota->nota_definitiva >= 3) ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ ($nota->nota_definitiva >= 3) ? 'success' : 'danger' }} border border-{{ ($nota->nota_definitiva >= 3) ? 'success' : 'danger' }} border-opacity-25 px-3">
                                                {{ ($nota->nota_definitiva >= 3) ? 'Aprobada' : 'Reprobada' }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3">
                                                En curso
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-white-50 mb-3">
                                            <i class="fa fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                                            Aún no hay calificaciones registradas para este año.
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

<style>
    /* Animaciones */
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes slideRight { from { transform: translateX(-20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    .dashboard-animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .dashboard-animate-slide-up { animation: slideUp 0.6s ease-out forwards; opacity: 0; }
    .dashboard-animate-slide-right { animation: slideRight 1s ease-out forwards; }

    .transition-all { transition: all 0.3s ease; }
    
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.4) !important;
        border-color: rgba(var(--bs-info-rgb), 0.3) !important;
    }

    .dashboard-btn-hover:hover {
        background-color: var(--bs-info);
        color: var(--bs-dark) !important;
        font-weight: bold;
    }

    .border-transparent { border-color: transparent; }
    .space-y-3 > * + * { margin-top: 0.75rem; }
</style>
@endsection