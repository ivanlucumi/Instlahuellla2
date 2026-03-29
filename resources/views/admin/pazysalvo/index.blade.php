@extends('layouts.Administracion')

@section('title', 'Paz y Salvo')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background:#fff !important;">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fa fa-tools text-primary opacity-25" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="color:#1e293b;">Módulo en Construcción</h2>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                        Estamos trabajando en la funcionalidad de generación de certificados de Paz y Salvo. 
                        Esta sección estará disponible en las próximas actualizaciones del sistema.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
