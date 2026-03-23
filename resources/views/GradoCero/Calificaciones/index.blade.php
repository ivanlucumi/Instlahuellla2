@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-white rounded h-100 p-4 text-center border shadow-sm">
                <div class="mb-4">
                    <i class="fa fa-pencil-alt fa-3x text-primary mb-3"></i>
                    <h4 class="mb-2 fw-bold text-dark">Calificar Grado Cero</h4>
                    <p class="text-muted">Seleccione los parámetros para abrir la matriz de calificación.</p>
                </div>
                
                <form action="{{ route('admin.grado-cero.calificaciones.matrix') }}" method="GET">
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold small text-uppercase">Grado Académico</label>
                        <select name="grado_id" class="form-select border-primary-subtle" required>
                            <option value="">Seleccione un grado...</option>
                            @foreach($grados as $g)
                                <option value="{{ $g->id }}">{{ $g->nombre_grado }} - {{ $g->curso->nombre_curso }} ({{ $g->sede->nombre_sede }})</option>
                            @endforeach
                        </select>
                        @if($grados->isEmpty())
                            <small class="text-danger mt-1">No tiene grados de transición asignados.</small>
                        @endif
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold small text-uppercase">Periodo Académico</label>
                        <select name="periodo_id" class="form-select border-primary-subtle" required>
                            @foreach($periodos as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre_periodo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold small text-uppercase">Año Escolar</label>
                        <select name="anho_escolar_id" class="form-select border-primary-subtle" required>
                            @foreach($anhos as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre_anho_escolar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold mt-2 shadow-sm" {{ $grados->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa fa-table me-2"></i>ABRIR MATRIZ DE CALIFICACIÓN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
