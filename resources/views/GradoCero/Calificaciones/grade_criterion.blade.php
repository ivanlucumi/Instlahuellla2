@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-0">Paso 4: Calificar Criterio</h6>
                        <p class="text-primary fw-bold mb-0">{{ $criterio->nombre_criterio }}</p>
                        <small class="text-white-50">{{ $criterio->asignatura->nombre_asignatura }} | {{ $grado->nombre_grado }}</small>
                    </div>
                    <a href="{{ route('admin.grado-cero.calificaciones.matrix', [
                        'grado_id' => $grado->id,
                        'periodo_id' => $periodo->id,
                        'anho_escolar_id' => $anho->id,
                        'asignatura_id' => $criterio->asignatura_id
                    ]) }}" class="btn btn-outline-light btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Volver a Criterios
                    </a>
                </div>

                <form action="{{ route('admin.grado-cero.calificaciones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="grado_id" value="{{ $grado->id }}">
                    <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                    <input type="hidden" name="anho_escolar_id" value="{{ $anho->id }}">
                    <input type="hidden" name="criterio_id" value="{{ $criterio->id }}">

                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th class="text-center">Siempre (S)</th>
                                    <th class="text-center">A veces (A)</th>
                                    <th class="text-center">Nunca (N)</th>
                                    <th>Observación Individual (Opcional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $e)
                                <tr>
                                    <td class="fw-bold">{{ $e->user->name }}</td>
                                    @php $val = $calificaciones[$e->id] ?? ''; @endphp
                                    <td class="text-center">
                                        <input class="form-check-input" type="radio" name="calificaciones[{{ $e->id }}]" value="SIEMPRE" {{ $val == 'SIEMPRE' ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="radio" name="calificaciones[{{ $e->id }}]" value="ALGUNAS_VECES" {{ $val == 'ALGUNAS_VECES' ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="radio" name="calificaciones[{{ $e->id }}]" value="NUNCA" {{ $val == 'NUNCA' ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="text" name="observaciones[{{ $e->id }}]" value="{{ $observaciones[$e->id] ?? '' }}" class="form-control form-control-sm bg-dark text-white border-0" placeholder="Nota rápida...">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fa fa-save me-2"></i>Guardar Calificaciones
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
