@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-0">Paso 3: Seleccionar Criterio / Logro</h6>
                        <small class="text-white-50">{{ $asignatura->nombre_asignatura }} | {{ $grado->nombre_grado }} | {{ $periodo->nombre_periodo }}</small>
                    </div>
                    <a href="{{ route('admin.grado-cero.calificaciones.matrix', [
                        'grado_id' => $grado->id,
                        'periodo_id' => $periodo->id,
                        'anho_escolar_id' => $anho->id
                    ]) }}" class="btn btn-outline-light btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Volver a Asignaturas
                    </a>
                </div>

                <div class="list-group">
                    @forelse($criterios as $c)
                        <a href="{{ route('admin.grado-cero.calificaciones.matrix', [
                            'grado_id' => $grado->id,
                            'periodo_id' => $periodo->id,
                            'anho_escolar_id' => $anho->id,
                            'asignatura_id' => $asignatura->id,
                            'criterio_id' => $c->id
                        ]) }}" class="list-group-item list-group-item-action bg-dark text-white border-secondary mb-2 rounded">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 text-primary">{{ $c->nombre_criterio }}</h6>
                                <span class="badge bg-primary rounded-pill"><i class="fa fa-chevron-right"></i></span>
                            </div>
                            <small class="text-white-50">Haga clic para calificar este criterio a todos los estudiantes.</small>
                        </a>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-exclamation-circle fa-3x text-warning mb-3"></i>
                            <p>No hay criterios activos para esta asignatura.</p>
                            <a href="{{ route('admin.grado-cero.criterios.create', ['asignatura_id' => $asignatura->id]) }}" class="btn btn-success">
                                <i class="fa fa-plus me-2"></i>Crear Criterio
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
