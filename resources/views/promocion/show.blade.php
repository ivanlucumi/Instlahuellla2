@extends('layouts.Administracion')

@section('title', 'Planilla de Promoción - ' . $grado->nombre_grado)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden transition-all">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 text-dark fw-bold">
                            <i class="fa fa-graduation-cap me-2 text-primary"></i> 
                            Planilla de Promoción: <span class="text-muted fw-normal fs-5">{{ $grado->nombre_grado }} - {{ $grado->bloque }}</span>
                        </h4>
                        <a href="{{ route('admin.promocion.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-4 shadow-sm">
                            <i class="fa fa-arrow-left me-1"></i> Volver al Listado
                        </a>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="stat-box">
                                <small class="stat-label">Total Estudiantes</small>
                                <span class="stat-value text-primary">{{ $estudiantes->count() }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box">
                                <small class="stat-label">Sede / Curso</small>
                                <span class="stat-text">{{ $grado->sede->nombre_sede ?? 'N/A' }} / {{ $grado->curso->nombre_curso ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box">
                                <small class="stat-label">Año Lectivo Actual</small>
                                <span class="stat-value" style="color:#343a40;">{{ $anoLectivo }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box d-flex flex-column gap-2" style="background:#f0f9f4 !important; border-color:#c3e6cb !important;">
                                <button type="button" onclick="selectAll('promovido')" class="btn btn-success rounded-pill py-1 shadow-sm" style="font-size:0.85rem;">
                                    <i class="fa fa-check-double me-1"></i> Todo Promover
                                </button>
                                <button type="button" onclick="selectAll('reproduce')" class="btn btn-danger rounded-pill py-1 shadow-sm" style="font-size:0.85rem;">
                                    <i class="fa fa-redo me-1"></i> Todo Repetir
                                </button>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.promocion.procesar') }}" method="POST" id="promotion-form">
                        @csrf
                        <input type="hidden" name="grado_origen_id" value="{{ $grado->id }}">
                        <input type="hidden" name="ano_lectivo_actual" value="{{ $anoLectivo }}">

                        <div class="table-responsive mb-4 rounded-3" style="max-height: 600px; overflow-y: auto; border: 1px solid #dee2e6;">
                            <table class="table table-hover align-middle small table-sm sticky-header m-0" style="background:#fff; color:#343a40;">
                                <thead>
                                    <tr style="background:#f8f9fa; color:#343a40; border-bottom: 2px solid #dee2e6;">
                                        <th rowspan="2" class="p-3 text-muted small uppercase-small border-0">Nro</th>
                                        <th rowspan="2" class="p-3 text-muted small uppercase-small border-0" style="min-width: 250px;">Estudiante</th>
                                        <th colspan="{{ $asignaturas->count() }}" class="text-center p-2 text-muted small uppercase-small border-0">Resumen de Asignaturas</th>
                                        <th rowspan="2" class="text-center p-3 text-muted small uppercase-small border-0">Perd.</th>
                                        <th rowspan="2" class="text-center p-3 text-success small uppercase-small border-0">Promover</th>
                                        <th rowspan="2" class="text-center p-3 text-danger small uppercase-small border-0">Repite</th>
                                    </tr>
                                    <tr style="background:#f8f9fa; color:#495057; border-bottom: 1px solid #dee2e6;">
                                        @foreach($asignaturas as $asig)
                                            <th class="p-2 vertical-text border-0" title="{{ $asig->nombre_asignatura }}">
                                                <div class="text-truncate text-muted" style="max-height: 100px; writing-mode: vertical-rl; transform: rotate(180deg); font-weight: normal;">
                                                    {{ $asig->nombre_asignatura }}
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estudiantes as $idx => $est)
                                        @php
                                            $data = $matrix[$est->id];
                                            $failing = $data['perdidas'] > 2;
                                        @endphp
                                        <tr style="background:{{ $failing ? '#fff9db' : '#fff' }};" class="hover-row table-row-light">
                                            <td class="text-center text-muted small">{{ $idx + 1 }}</td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $est->user->name }}</div>
                                                <small class="text-muted">{{ $est->numero_identificacion_estudiante }}</small>
                                            </td>
                                            
                                            @foreach($asignaturas as $asig)
                                                @php $val = $data['notas'][$asig->id]; @endphp
                                                <td class="text-center border-0 {{ ($val !== null && $val < 3.0) ? 'text-danger fw-bold' : 'text-muted' }}">
                                                    {{ $val !== null ? number_format($val, 1) : '-' }}
                                                </td>
                                            @endforeach

                                            <td class="text-center fw-bold {{ $data['perdidas'] > 0 ? ($data['perdidas'] > 2 ? 'text-danger' : 'text-warning') : 'text-success' }}">
                                                {{ $data['perdidas'] }}
                                            </td>

                                            <td class="text-center">
                                                <div class="custom-radio-group">
                                                    <input type="radio" name="status[{{ $est->id }}]" value="promovido" 
                                                           id="p_{{ $est->id }}"
                                                           class="custom-btn-check check-promover" 
                                                           {{ $data['perdidas'] <= 2 ? 'checked' : '' }}
                                                           data-student-id="{{ $est->id }}">
                                                    <label for="p_{{ $est->id }}" class="custom-btn label-promote">
                                                        <i class="fa fa-check"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="custom-radio-group">
                                                    <input type="radio" name="status[{{ $est->id }}]" value="reproduce" 
                                                           id="r_{{ $est->id }}"
                                                           class="custom-btn-check check-repite"
                                                           {{ $data['perdidas'] > 2 ? 'checked' : '' }}
                                                           data-student-id="{{ $est->id }}">
                                                    <label for="r_{{ $est->id }}" class="custom-btn label-repeat">
                                                        <i class="fa fa-redo"></i>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="estudiantes-data"></div>

                        @php
                            $user = auth()->user();
                            $isSuperAdmin = $user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN');
                            $isGradeDirector = \App\Models\Docente::where('user_id', $user->id)->where('id', $grado->docente_id)->exists();
                            $canProcess = $isSuperAdmin || $isGradeDirector;
                        @endphp

                        <div class="promo-config-box mt-4">
                            <div class="row g-4 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label text-primary small fw-bold uppercase-small tracking-wider">Año de Matrícula Destino</label>
                                    <select name="ano_lectivo_destino" class="form-select border-primary-subtle rounded-pill shadow-sm" required>
                                        @php $nextYear = intval($anoLectivo) + 1; @endphp
                                        <option value="{{ $nextYear }}" selected>{{ $nextYear }} (Siguiente Año)</option>
                                        @foreach($anhosEscolares as $anho)
                                            <option value="{{ $anho->nombre_anho_escolar }}">{{ $anho->nombre_anho_escolar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                @php
                                    $nombreGrado = strtoupper($grado->nombre_grado);
                                    $esOnce = (str_contains($nombreGrado, 'ONCE') || str_contains($nombreGrado, 'UNDECIMO'));
                                @endphp

                                @if(!$esOnce)
                                <div class="col-md-5">
                                    <label class="form-label text-primary small fw-bold uppercase-small tracking-wider">Grado Escolar Superior</label>
                                    <select name="grado_destino_id" class="form-select border-primary-subtle rounded-pill shadow-sm">
                                        <option value="">Seleccione el siguiente nivel...</option>
                                        @foreach($todosLosGrados as $g)
                                            <option value="{{ $g->id }}">{{ $g->nombre_grado }} - {{ $g->bloque }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-muted mt-2 small">
                                        <i class="fa fa-info-circle me-1 text-primary"></i> Los estudiantes que **repiten** permanecerán matriculados en {{ $grado->nombre_grado }}.
                                    </div>
                                </div>
                                @else
                                <div class="col-md-5">
                                    <div class="alert alert-info border-0 shadow-sm small m-0 rounded-4">
                                        <i class="fa fa-info-circle me-2"></i> **Ciclo de Undécimo**: Los alumnos promovidos culminan su ciclo institucional. Los reprobados repetirán Grado Once en el nuevo periodo.
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    @if($canProcess)
                                        <button type="button" onclick="confirmPromotion()" class="btn btn-primary w-100 rounded-pill py-3 fw-bold transition-all shadow-btn shadow-sm">
                                            <i class="fa fa-check-circle me-2"></i> Finalizar y Procesar Promoción
                                        </button>
                                    @else
                                        <div class="alert alert-warning border-0 shadow-sm small m-0 rounded-4">
                                            <i class="fa fa-lock me-2 text-dark"></i> Solo el **Director de Grado** asignado tiene permisos para procesar.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ====== STAT BOXES ====== */
.stat-box {
    padding: 14px 16px;
    border-radius: 10px;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.stat-label {
    display: block;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6c757d !important;
    margin-bottom: 4px;
    font-weight: 500;
}
.stat-value {
    display: block;
    font-size: 1.4rem;
    font-weight: 700;
    color: #0d6efd;
}
.stat-text {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #343a40 !important;
}

/* ====== PROMO CONFIG PANEL ====== */
.promo-config-box {
    padding: 24px;
    border-radius: 12px;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.promo-config-box label {
    color: #0d6efd !important;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* ====== TABLE - Force light theme ====== */
.sticky-header th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #f8f9fa !important;
    color: #495057 !important;
}
.sticky-header td {
    background-color: #ffffff;
    color: #343a40;
}
.table-row-light td {
    color: #343a40 !important;
}

/* ====== hover ====== */
.hover-row { transition: background-color 0.2s ease; }
.hover-row:hover td { background-color: #eff6ff !important; }

.uppercase-small { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.06em; }
.tracking-wider { letter-spacing: 0.05em; }

/* ====== Custom Radio Buttons ====== */
.custom-radio-group { display: flex; justify-content: center; }
.custom-btn-check { display: none; }
.custom-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    border: 1px solid #ced4da;
    color: #ced4da;
    font-size: 1rem;
    background-color: #ffffff;
}
.label-promote:hover { background-color: #d1fae5; color: #065f46; border-color: #34d399; }
.label-repeat:hover  { background-color: #fee2e2; color: #991b1b; border-color: #f87171; }

.custom-btn-check:checked + .label-promote {
    background-color: #16a34a;
    color: #fff;
    border-color: #16a34a;
    box-shadow: 0 3px 10px rgba(22, 163, 74, 0.25);
    transform: scale(1.1);
}
.custom-btn-check:checked + .label-repeat {
    background-color: #dc2626;
    color: #fff;
    border-color: #dc2626;
    box-shadow: 0 3px 10px rgba(220, 38, 38, 0.25);
    transform: scale(1.1);
}
.shadow-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2) !important;
}
.vertical-text {
    height: 130px;
    white-space: nowrap;
    position: relative;
    padding-bottom: 10px;
}
.transition-all { transition: all 0.3s ease; }
</style>

<script>
function selectAll(type) {
    const checks = document.querySelectorAll(`.check-${type}`);
    checks.forEach(check => {
        check.checked = true;
    });
}

function confirmPromotion() {
    const form = document.getElementById('promotion-form');
    const dataContainer = document.getElementById('estudiantes-data');
    dataContainer.innerHTML = '';

    const checks = form.querySelectorAll('.custom-btn-check:checked');
    let promovidos = 0;
    let reprobados = 0;

    checks.forEach(check => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = check.value === 'promovido' ? 'estudiantes_promovidos[]' : 'estudiantes_reprobados[]';
        input.value = check.dataset.studentId;
        dataContainer.appendChild(input);
        
        if (check.value === 'promovido') promovidos++;
        else reprobados++;
    });

    if (promovidos === 0 && reprobados === 0) {
        Swal.fire('Atención', 'Selección Vacía: Por favor elija el estado de los estudiantes antes de continuar.', 'warning');
        return;
    }

    Swal.fire({
        title: '¿Confirmar Procesamiento?',
        text: `Usted está a punto de procesar ${promovidos} alumnos promovidos y ${reprobados} alumnos para repetir grado. Se generarán las matrículas correspondientes para el nuevo año escolar.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, confirmar y procesar',
        cancelButtonText: 'Cancelar y revisar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection
