@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-0">Paso 2: Seleccionar Asignatura / Dimensión</h6>
                        <small class="text-white-50">{{ $grado->nombre_grado }} | {{ $periodo->nombre_periodo }} | {{ $anho->nombre_anho_escolar }}</small>
                    </div>
                    <a href="{{ route('admin.grado-cero.calificaciones.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Volver al inicio
                    </a>
                </div>

                <div class="row g-4">
                    @forelse($asignaturas as $a)
                        <div class="col-sm-6 col-xl-3">
                            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4 h-100">
                                <i class="fa fa-book-open fa-3x text-primary"></i>
                                <div class="ms-3 text-end">
                                    <p class="mb-2">{{ $a->nombre_asignatura }}</p>
                                    <a href="{{ route('admin.grado-cero.calificaciones.matrix', [
                                        'grado_id' => $grado->id,
                                        'periodo_id' => $periodo->id,
                                        'anho_escolar_id' => $anho->id,
                                        'asignatura_id' => $a->id
                                    ]) }}" class="btn btn-primary btn-sm">Seleccionar</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No hay asignaturas vinculadas a este grado.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
