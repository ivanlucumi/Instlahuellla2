@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4 border shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div>
                        <h4 class="mb-0 text-primary fw-bold">Promover / Matricular Estudiantes</h4>
                        <p class="text-muted mb-0 small">
                            <i class="fa fa-graduation-cap me-1"></i> Origen: {{ $grado->nombre_grado }} ({{ $grado->curso->nombre_curso }}) 
                        </p>
                    </div>
                    <a href="{{ route('admin.grado-cero.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Volver
                    </a>
                </div>

                <form action="{{ route('admin.grado-cero.calificaciones.procesar-promocion') }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6 border-end">
                            <h6 class="mb-3 text-primary">1. Selección de Destino</h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-uppercase">Grado / Curso Destino</label>
                                    <select name="grado_destino_id" class="form-select border-primary-subtle" required>
                                        <option value="">Seleccione grado destino...</option>
                                        @foreach($gradosDestino as $gd)
                                            <option value="{{ $gd->id }}">{{ $gd->nombre_grado }} - {{ $gd->curso->nombre_curso }} ({{ $gd->sede->nombre_sede }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-uppercase">Año Lectivo Destino</label>
                                    <select name="anho_destino_id" class="form-select border-primary-subtle" required>
                                        @foreach($anhosDestino as $ad)
                                            <option value="{{ $ad->id }}" {{ $ad->estado_anho_escolar == 1 ? 'selected' : '' }}>{{ $ad->nombre_anho_escolar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ps-4">
                            <h6 class="mb-3 text-primary">2. Confirmación</h6>
                            <p class="small text-muted mb-4">
                                Esta acción actualizará el grado actual de los estudiantes seleccionados y los matriculará automáticamente en el ciclo escolar elegido.
                            </p>
                            <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm w-100 py-3">
                                <i class="fa fa-rocket me-2"></i>PROCESAR MATRÍCULA Y PROMOCIÓN
                            </button>
                        </div>
                    </div>

                    <h6 class="mb-3 text-primary border-bottom pb-2">3. Listado de Estudiantes a Promover</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                    </th>
                                    <th>Estudiante</th>
                                    <th>Identificación</th>
                                    <th class="text-center">Estado Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $e)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="estudiantes[]" value="{{ $e->id }}" class="form-check-input student-checkbox">
                                    </td>
                                    <td class="fw-bold">{{ strtoupper($e->user->name) }}</td>
                                    <td class="text-muted">{{ $e->codigo_estudiante }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success">Activo</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.checked = checked;
        });
    });
</script>
@endsection
