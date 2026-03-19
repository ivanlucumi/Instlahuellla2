@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    {{-- Hero Section --}}
    <div class="row g-4 mb-4 dashboard-animate-fade-in">
        <div class="col-12">
            <div class="bg-secondary rounded p-5 shadow-lg position-relative overflow-hidden border-start border-5 border-primary">
                <div class="row align-items-center">
                    <div class="col-lg-7 position-relative" style="z-index: 2;">
                        <h1 class="display-4 fw-bold text-white mb-3">
                            Bienvenido a <span class="text-primary">{{ $institucion?->nombre_institucion ?? 'Nuestra Institución' }}</span>
                        </h1>
                        <p class="lead text-white-50 mb-4">
                            {{ $institucion?->descripcion_institucion ?? 'Comprometidos con la excelencia académica y la formación integral de nuestros estudiantes.' }}
                        </p>
                        <div class="d-flex gap-3">
                            <div class="p-3 bg-dark rounded shadow-sm border border-primary border-opacity-25">
                                <small class="text-primary d-block mb-1">Código DANE</small>
                                <span class="h5 mb-0 text-white">{{ $institucion?->codigo_dane ?? 'N/A' }}</span>
                            </div>
                            <div class="p-3 bg-dark rounded shadow-sm border border-primary border-opacity-25">
                                <small class="text-primary d-block mb-1">Resolución</small>
                                <span class="h6 mb-0 text-white text-truncate d-inline-block" style="max-width: 200px;">
                                    {{ $institucion?->resolucion_institucion ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- Imagen a la derecha --}}
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <div class="hero-image-container position-relative">
                            <img src="{{ asset('panelAdmin/img/institutional_hero.png') }}" 
                                 alt="Institución" 
                                 class="img-fluid rounded-3 shadow-lg dashboard-animate-slide-right"
                                 style="max-height: 350px; object-fit: cover; border: 4px solid rgba(255,255,255,0.1);">
                            <div class="hero-overlay-gradient"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats/Quick Metrics --}}
    <div class="row g-4 mb-4">
        @php
            $stats = [
                ['label' => 'Estudiantes', 'val' => \App\Models\Estudiante::count(), 'icon' => 'fa-users', 'color' => 'primary'],
                ['label' => 'Docentes', 'val' => \App\Models\Docente::count(), 'icon' => 'fa-chalkboard-teacher', 'color' => 'success'],
                ['label' => 'Cursos', 'val' => \App\Models\Curso::count(), 'icon' => 'fa-graduation-cap', 'color' => 'info'],
                ['label' => 'Sedes', 'val' => \App\Models\Sede::count(), 'icon' => 'fa-building', 'color' => 'warning'],
            ];
        @endphp

        @foreach($stats as $index => $stat)
        <div class="col-sm-6 col-xl-3 dashboard-animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow-sm hover-elevate transition-all">
                <i class="fa {{ $stat['icon'] }} fa-3x text-{{ $stat['color'] }}"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2 text-white-50 small">{{ $stat['label'] }}</p>
                    <h4 class="mb-0 text-white">{{ $stat['val'] }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Mission/Vision Section --}}
    <div class="row g-4 dashboard-animate-fade-in" style="animation-delay: 0.5s">
        <div class="col-md-6">
            <div class="bg-secondary rounded p-4 h-100 shadow-sm border-bottom border-3 border-primary">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-primary bg-opacity-10 rounded me-3">
                        <i class="fa fa-bullseye text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-white">Nuestra Misión</h5>
                </div>
                <p class="text-white-50 mb-0">
                    Proporcionar una educación de calidad que fomente el pensamiento crítico, la creatividad y los valores éticos, preparando a nuestros estudiantes para los desafíos del futuro y su contribución positiva a la sociedad.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-secondary rounded p-4 h-100 shadow-sm border-bottom border-3 border-info">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-info bg-opacity-10 rounded me-3">
                        <i class="fa fa-eye text-info"></i>
                    </div>
                    <h5 class="mb-0 text-white">Nuestra Visión</h5>
                </div>
                <p class="text-white-50 mb-0">
                    Ser una institución educativa líder y referente a nivel nacional, reconocida por su innovación pedagógica, excelencia académica y por formar ciudadanos íntegros capaces de liderar cambios significativos en su entorno.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animaciones Custom */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes slideRight {
        from { transform: translateX(-30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .dashboard-animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .dashboard-animate-slide-up { animation: slideUp 0.6s ease-out forwards; opacity: 0; }
    .dashboard-animate-slide-right { animation: slideRight 0.8s ease-out forwards; }

    .transition-all { transition: all 0.3s ease; }
    
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3) !important;
    }

    .hero-image-container::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(45deg, rgba(var(--bs-primary-rgb), 0.1), transparent);
        pointer-events: none;
        border-radius: 0.5rem;
    }

    .border-opacity-25 { border-color: rgba(var(--bs-primary-rgb), 0.25) !important; }
</style>
@endsection
