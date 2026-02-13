@extends('layouts.Administracion')

@section('title', 'Institución Educativa Técnica Agropecuaria La Huella')

@section('content')

<div class="row justify-content-center">
    @forelse($instituciones as $inst)

        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
            <div class="card bg-secondary text-white shadow-lg border-0 mb-4 institution-card">

                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">
                            {{ $inst->nombre_institucion }}
                        </h4>
                        <span class="badge bg-dark">
                            Código DANE: {{ $inst->codigo_dane }}
                        </span><br>
                        <span class="badge bg-dark">
                            Resolución: {{ $inst->resolucion_institucion }}
                        </span><br>
                        <span class="badge bg-dark">
                            {{ $inst->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Ciudad:</strong></p>
                            <span>{{ $inst->ciudad_institucion }}</span>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1"><strong>Departamento:</strong></p>
                            <span>{{ $inst->departamento_institucion }}</span>
                        </div>

                        <div class="col-md-12">
                            <p class="mb-1"><strong>Rector:</strong></p>
                            <span>{{ $inst->rector->name ?? 'No asignado' }}</span>
                        </div>

                        @if($inst->resolucion)
                        <div class="col-md-12">
                            <p class="mb-1"><strong>Resolución:</strong></p>
                            <span>{{ $inst->resolucion_institucion }}</span>
                        </div>
                        @endif
                    </div>

                </div>

                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.institucion.edit', $inst) }}"
                       class="btn btn-warning px-4">
                        <i class="fa fa-edit me-1"></i> Editar institución
                    </a>
                </div>

            </div>
        </div>

    @empty
        <div class="col-12 text-center">
            <div class="alert alert-warning">
                No hay instituciones registradas
            </div>
            <a href="{{ route('admin.institucion.create') }}" class="btn btn-primary">
                Crear Institución
            </a>
        </div>
    @endforelse
</div>

@endsection
