@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4 border shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    @php
                        $user = auth()->user();
                        $isAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('RECTOR');
                    @endphp
                    <div>
                        <h4 class="mb-0 text-primary fw-bold">Matriz de Calificación: Grado Cero</h4>
                        <div class="mt-1">
                            <span class="badge bg-primary me-1"><i class="fa fa-graduation-cap me-1"></i> {{ $grado->nombre_grado }}</span>
                            <span class="badge bg-info me-1"><i class="fa fa-calendar-alt me-1"></i> {{ $periodo->nombre_periodo }}</span>
                            <span class="badge bg-secondary me-1"><i class="fa fa-clock me-1"></i> {{ $anho->nombre_anho_escolar }}</span>
                            <span class="text-muted small ms-2">{{ $grado->curso->nombre_curso }} | {{ $grado->sede->nombre_sede }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.grado-cero.calificaciones.promocion', $grado->id) }}" class="btn btn-primary btn-sm me-2 fw-bold">
                            <i class="fa fa-user-graduate me-2"></i>Promover Estudiantes
                        </a>
                        <a href="{{ route('admin.grado-cero.boletin.grupo', [$grado->id, $periodo->id, $anho->id]) }}" class="btn btn-outline-success btn-sm me-2" target="_blank">
                            <i class="fa fa-file-pdf me-2"></i>Boletines {{ $periodo->nombre_periodo }}
                        </a>
                        <a href="{{ route('admin.grado-cero.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.grado-cero.calificaciones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="grado_id" value="{{ $grado->id }}">
                    <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                    <input type="hidden" name="anho_escolar_id" value="{{ $anho->id }}">

                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto; overflow-x: auto;">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="sticky-top bg-light" style="z-index: 1000;">
                                <tr class="bg-light">
                                    <th rowspan="2" class="text-center align-middle sticky-col" style="min-width: 280px;">
                                        Estudiante / Identificación
                                    </th>
                                    @foreach($criterios as $asignatura => $logros)
                                        <th colspan="{{ $logros->count() }}" class="text-center bg-info text-white py-1 small">
                                            {{ strtoupper($asignatura) }}
                                        </th>
                                    @endforeach
                                    <th rowspan="2" class="text-center align-middle bg-light" style="min-width: 300px;">Observaciones / Fortalezas</th>
                                </tr>
                                <tr class="bg-light">
                                    @foreach($criterios as $asignatura => $logros)
                                        @foreach($logros as $l)
                                            <th class="small text-center py-1 px-1 bg-light fw-normal" style="min-width: 90px; font-size: 0.65rem;" title="{{ $l->nombre_criterio }}">
                                                {{ Str::limit($l->nombre_criterio, 20) }}
                                            </th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $e)
                                <tr>
                                    <td class="sticky-col bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ strtoupper($e->user->name) }}</span>
                                                <span class="text-muted small" style="font-size: 0.65rem;">ID: {{ $e->codigo_estudiante }}</span>
                                            </div>
                                            <a href="{{ route('admin.grado-cero.boletin.descargar', [$e->id, $periodo->id, $anho->id]) }}" 
                                               class="btn btn-outline-danger btn-xs py-0 px-1 border-0" 
                                               target="_blank" 
                                               title="Descargar Boletín Individual">
                                                <i class="fa fa-file-pdf" style="font-size: 0.75rem;"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @foreach($criterios as $asignatura => $logros)
                                        @foreach($logros as $l)
                                        <td class="p-1 text-center">
                                            @php
                                                $currentVal = $calificaciones->get($e->id)?->where('criterio_id', $l->id)->first()?->valor;
                                            @endphp
                                            <div class="d-flex justify-content-center gap-1">
                                                <div class="form-check form-check-inline m-0 p-0" title="Siempre">
                                                    <input class="form-check-input d-none" type="radio" 
                                                           name="calificaciones[{{ $e->id }}][{{ $l->id }}]" 
                                                           id="c_{{ $e->id }}_{{ $l->id }}_S" 
                                                           value="SIEMPRE" {{ $currentVal == 'SIEMPRE' ? 'checked' : '' }}
                                                           {{ (!$isAdmin && $currentVal) ? 'disabled' : '' }}>
                                                    <label class="btn btn-outline-success btn-xs p-1" for="c_{{ $e->id }}_{{ $l->id }}_S" 
                                                           style="font-size: 0.6rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; {{ (!$isAdmin && $currentVal && $currentVal != 'SIEMPRE') ? 'opacity: 0.3;' : '' }}">S</label>
                                                </div>
                                                <div class="form-check form-check-inline m-0 p-0" title="Algunas veces">
                                                    <input class="form-check-input d-none" type="radio" 
                                                           name="calificaciones[{{ $e->id }}][{{ $l->id }}]" 
                                                           id="c_{{ $e->id }}_{{ $l->id }}_A" 
                                                           value="ALGUNAS_VECES" {{ $currentVal == 'ALGUNAS_VECES' ? 'checked' : '' }}
                                                           {{ (!$isAdmin && $currentVal) ? 'disabled' : '' }}>
                                                    <label class="btn btn-outline-warning btn-xs p-1" for="c_{{ $e->id }}_{{ $l->id }}_A" 
                                                           style="font-size: 0.6rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; {{ (!$isAdmin && $currentVal && $currentVal != 'ALGUNAS_VECES') ? 'opacity: 0.3;' : '' }}">A</label>
                                                </div>
                                                <div class="form-check form-check-inline m-0 p-0" title="Nunca">
                                                    <input class="form-check-input d-none" type="radio" 
                                                           name="calificaciones[{{ $e->id }}][{{ $l->id }}]" 
                                                           id="c_{{ $e->id }}_{{ $l->id }}_N" 
                                                           value="NUNCA" {{ $currentVal == 'NUNCA' ? 'checked' : '' }}
                                                           {{ (!$isAdmin && $currentVal) ? 'disabled' : '' }}>
                                                    <label class="btn btn-outline-danger btn-xs p-1" for="c_{{ $e->id }}_{{ $l->id }}_N" 
                                                           style="font-size: 0.6rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; {{ (!$isAdmin && $currentVal && $currentVal != 'NUNCA') ? 'opacity: 0.3;' : '' }}">N</label>
                                                </div>
                                            </div>
                                        </td>
                                        @endforeach
                                    @endforeach
                                    <td class="p-1">
                                        @php $obs = $observaciones[$e->id] ?? ''; @endphp
                                        <textarea name="observaciones[{{ $e->id }}]" 
                                                  class="form-control form-control-sm border-light bg-light" 
                                                  rows="2" 
                                                  style="font-size: 0.7rem;" 
                                                  placeholder="Observaciones..."
                                                  {{ (!$isAdmin && $obs) ? 'readonly' : '' }}>{{ $obs }}</textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded d-flex justify-content-between align-items-center border">
                        <div class="text-muted small">
                            <strong>Leyenda:</strong> 
                            <span class="badge bg-success">S</span> Siempre | 
                            <span class="badge bg-warning text-dark">A</span> Algunas veces | 
                            <span class="badge bg-danger">N</span> Nunca
                        </div>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fa fa-save me-2"></i>GUARDAR CALIFICACIONES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-xs { padding: 0.1rem 0.2rem; line-height: 1; }
    .form-check-input:checked + label.btn-outline-success { background-color: #198754; color: white; }
    .form-check-input:checked + label.btn-outline-warning { background-color: #ffc107; color: black; }
    .form-check-input:checked + label.btn-outline-danger { background-color: #dc3545; color: white; }
    
    .table-responsive::-webkit-scrollbar { width: 8px; height: 8px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #adb5bd; border-radius: 4px; }
    .table-responsive::-webkit-scrollbar-track { background: #f8f9fa; }
    
    .sticky-top { position: sticky; top: 0; z-index: 1000; }
    
    .sticky-col {
        position: sticky;
        left: 0;
        z-index: 500;
        background-color: #f8f9fa !important;
        border-right: 2px solid #dee2e6 !important;
        box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }
    
    thead th.sticky-col {
        z-index: 1100; /* Above regular sticky-top */
    }
</style>
@endsection
