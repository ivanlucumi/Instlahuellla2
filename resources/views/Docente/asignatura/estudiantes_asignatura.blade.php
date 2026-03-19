@extends('layouts.Administracion')

@section('title', 'Estudiantes - ' . $asignatura->nombre_asignatura)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h4 class="text-dark fw-bold mb-1">{{ $asignatura->nombre_asignatura }} <span class="text-muted fw-normal">| Curso {{ $grado->bloque }}</span></h4>
            <div class="d-flex align-items-center flex-wrap gap-2 mt-2">
                <span class="badge bg-light text-primary border"><i class="fa fa-calendar-alt me-1"></i> {{ $anoLectivo }}</span>
                <span class="badge bg-light text-info border"><i class="fa fa-graduation-cap me-1"></i> {{ $grado->nombre_grado }}</span>
                <span class="badge bg-light text-secondary border">{{ $asignatura->hilo->nombre_hilo ?? 'N/A' }}</span>
                @if(!$esAnoActual)
                    <span class="badge bg-warning text-dark"><i class="fa fa-lock me-1"></i> HISTÓRICO</span>
                @endif
                @if($esAnoActual && !$canEdit)
                    <span class="badge bg-info text-white"><i class="fa fa-eye me-1"></i> MODO SUPERVISIÓN</span>
                @endif
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('docente.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fa fa-arrow-left me-1"></i> Volver al Panel
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('docente.notas.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                        <input type="hidden" name="grado_id" value="{{ $grado->id }}">

                        @if(!$esAnoActual)
                            <div class="alert alert-light border shadow-sm mb-4 border-start border-4 border-warning">
                                <i class="fa fa-exclamation-triangle me-2 text-warning"></i>
                                <strong>Modo Lectura:</strong> Está visualizando registros históricos. No se permiten modificaciones.
                            </div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr class="text-muted small text-uppercase fw-bold">
                                        <th style="width: 40px;">
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                        <th>Estudiante</th>
                                        <th class="text-center">P1</th>
                                        <th class="text-center">P2</th>
                                        <th class="text-center">P3</th>
                                        <th class="text-center">P4</th>
                                        <th class="text-center">Definitiva</th>
                                        <th>Observaciones</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estudiantes as $estudiante)
                                        @php
                                            $notaObj = $estudiante->notas->first(); 
                                            $definitiva = $notaObj->nota_definitiva ?? 0;
                                            $isApto = ($notaObj && $definitiva >= 3);
                                        @endphp
                                        <tr id="row-{{ $estudiante->id }}" class="border-bottom-0">
                                            <td>
                                                <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->id }}" 
                                                    class="form-check-input student-checkbox" 
                                                    data-apto="{{ $isApto ? '1' : '0' }}"
                                                    data-nombre="{{ $estudiante->user->name }}">
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">
                                                    {{ $estudiante->user->name }}
                                                    @if(!$isApto)
                                                        <i class="bi bi-exclamation-circle-fill text-muted ms-1" title="Bajo rendimiento"></i>
                                                    @else
                                                        <i class="bi bi-check-circle-fill text-success ms-1" title="Aprobado"></i>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $estudiante->numero_identificacion_estudiante }}</small>
                                            </td>
                                            <td style="width: 80px;">
                                                <input type="number" name="notas[{{ $estudiante->id }}][nota1]" class="form-control form-control-sm text-center nota-input border-0 bg-light" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota1 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                            </td>
                                            <td style="width: 80px;">
                                                <input type="number" name="notas[{{ $estudiante->id }}][nota2]" class="form-control form-control-sm text-center nota-input border-0 bg-light" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota2 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                            </td>
                                            <td style="width: 80px;">
                                                <input type="number" name="notas[{{ $estudiante->id }}][nota3]" class="form-control form-control-sm text-center nota-input border-0 bg-light" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota3 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                            </td>
                                            <td style="width: 80px;">
                                                <input type="number" name="notas[{{ $estudiante->id }}][nota4]" class="form-control form-control-sm text-center nota-input border-0 bg-light" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota4 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                            </td>
                                            <td class="text-center fw-bold">
                                                <span id="def-{{ $estudiante->id }}" class="badge rounded-pill {{ $definitiva >= 3 ? 'bg-success' : ($definitiva > 0 ? 'bg-danger' : 'bg-light text-muted border') }}">
                                                    {{ number_format($definitiva, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <input type="text" name="notas[{{ $estudiante->id }}][observaciones]" id="obs-{{ $estudiante->id }}" class="form-control form-control-sm border-0 bg-light obs-input" value="{{ $notaObj->observaciones ?? '' }}" placeholder="..." readonly>
                                            </td>
                                            <td class="text-center">
                                                @if($esAnoActual)
                                                    @if($canEdit)
                                                        <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none edit-btn shadow-none" onclick="enableEdit('{{ $estudiante->id }}')">
                                                            <i class="fa fa-edit me-1"></i> Editar
                                                        </button>
                                                    @else
                                                        <span class="badge bg-light text-muted border"><i class="fa fa-eye me-1"></i> Solo Lectura</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small"><i class="fa fa-lock"></i> Bloqueado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($esAnoActual && $canEdit)
                            <div class="mt-4 p-3 bg-light rounded d-flex align-items-center">
                                <button type="submit" class="btn btn-dark px-4 rounded-pill shadow-sm" id="save-btn" disabled>
                                    <i class="bi bi-save me-1"></i> Guardar Cambios
                                </button>
                                <span class="ms-3 text-muted small" id="edit-warning" style="display: none;">
                                    <i class="bi bi-info-circle me-1 text-warning"></i> Complete las observaciones para guardar.
                                </span>
                            </div>
                        @elseif($esAnoActual && !$canEdit)
                            <div class="mt-4 p-3 bg-light rounded text-muted small">
                                <i class="fa fa-info-circle me-1"></i> Está visualizando este registro como **Director de Grado**. Solo el docente asignado puede modificar las calificaciones.
                            </div>
                        @endif
                    </form>

                    @if($all_graded && $esAnoActual)
                    <div class="mt-5 pt-4 border-top">
                        <div class="card border-0 bg-light shadow-none">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-dark mb-4">
                                    <i class="bi bi-mortarboard-fill me-2 text-secondary"></i> Promover Estudiantes
                                </h5>
                                
                                <form action="{{ route('docente.estudiantes.promover') }}" method="POST" id="promote-form">
                                    @csrf
                                    <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                                    <input type="hidden" name="grado_origen_id" value="{{ $grado->id }}">
                                    <div id="selected-students-container"></div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label text-dark small fw-bold">Grado de Destino</label>
                                            <select name="grado_destino_id" class="form-select border-0 shadow-sm" required>
                                                <option value="">Seleccione el curso...</option>
                                                @foreach($todosLosGrados as $g)
                                                    <option value="{{ $g->id }}">{{ $g->nombre_grado }} - {{ $g->bloque }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-end gap-2">
                                            <button type="button" onclick="submitPromotion('manual')" class="btn btn-dark rounded-pill px-4">
                                                <i class="bi bi-person-check me-1"></i> Promover Seleccionados
                                            </button>
                                            <button type="button" onclick="submitPromotion('total')" class="btn btn-outline-dark rounded-pill px-4">
                                                <i class="bi bi-people-fill me-1"></i> Promover Grupo Apto
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @elseif($esAnoActual)
                    <div class="alert alert-light border shadow-sm mt-5 mb-0">
                        <i class="bi bi-info-circle me-2 text-info"></i>
                        La sección de promoción se habilitará cuando **todos** los estudiantes tengan calificación definitiva.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const saveBtn = document.getElementById('save-btn');
    const editWarning = document.getElementById('edit-warning');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }

    const inputs = document.querySelectorAll('.nota-input');
    
    function calculateRow(studentId) {
        const studentInputs = document.querySelectorAll(`.nota-input[data-student="${studentId}"]`);
        const badge = document.getElementById(`def-${studentId}`);
        const obsInput = document.getElementById(`obs-${studentId}`);
        const checkbox = document.querySelector(`.student-checkbox[value="${studentId}"]`);
        const row = document.getElementById(`row-${studentId}`);
        
        const n1 = parseFloat(document.querySelector(`input[name="notas[${studentId}][nota1]"]`).value) || 0;
        const n2 = parseFloat(document.querySelector(`input[name="notas[${studentId}][nota2]"]`).value) || 0;
        const n3 = parseFloat(document.querySelector(`input[name="notas[${studentId}][nota3]"]`).value) || 0;
        const n4 = parseFloat(document.querySelector(`input[name="notas[${studentId}][nota4]"]`).value) || 0;
        
        // Verifica si hay algun campo llenado (para las observaciones)
        let hasValues = false;
        studentInputs.forEach(input => {
            if (input.value !== '') hasValues = true;
        });

        let avg = 0;
        if (n3 > 0) {
            if (n4 > 0) {
                avg = (n1 + n2 + n3 + n4) / 4;
            } else {
                avg = (n1 + n2 + n3) / 3;
            }
        }

        if (n3 > 0) {
            const isApto = avg >= 3;
            badge.textContent = avg.toFixed(2);
            badge.classList.remove('bg-danger', 'bg-success');
            badge.classList.add(isApto ? 'bg-success' : 'bg-danger');
            
            // Actualizar elegibilidad
            checkbox.dataset.apto = isApto ? '1' : '0';
            const icon = row.querySelector('.bi-exclamation-circle-fill, .bi-check-circle-fill');
            if (icon) {
                icon.className = isApto ? 'bi bi-check-circle-fill text-success ms-1' : 'bi bi-exclamation-circle-fill text-danger ms-1';
                icon.title = isApto ? 'Apto para promoción' : 'No apto para promoción (Nota < 3.0)';
            }
        } else {
            // Si P3 no se ha llenado (n3 <= 0), no hay definitiva real aún (0)
            badge.textContent = '0.00';
            badge.classList.remove('bg-success');
            badge.classList.add('bg-secondary');
            
            checkbox.dataset.apto = '0';
            const icon = row.querySelector('.bi-exclamation-circle-fill, .bi-check-circle-fill');
            if (icon) {
                icon.className = 'bi bi-dash-circle text-muted ms-1';
                icon.title = 'Requiere al menos 3 periodos para promoción';
            }
        }

        // Requerir observaciones visualmente si hay calificacion
        if (hasValues) {
            if (obsInput.value.trim() === '') {
                obsInput.classList.add('border', 'border-warning');
                obsInput.classList.remove('border-0');
            } else {
                obsInput.classList.remove('border', 'border-warning');
                obsInput.classList.add('border-0');
            }
        } else {
            obsInput.classList.remove('border', 'border-warning');
            obsInput.classList.add('border-0');
        }

        validateForm();
    }

    function validateForm() {
        let anyChanges = false;
        let allValid = true;

        const editedRows = document.querySelectorAll('.row-editing');
        anyChanges = editedRows.length > 0;

        editedRows.forEach(row => {
            const studentId = row.id.replace('row-', '');
            const studentInputs = row.querySelectorAll('.nota-input');
            const obsInput = row.querySelector('.obs-input');
            
            let hasGrades = false;
            studentInputs.forEach(input => {
                if (input.value !== '') hasGrades = true;
            });

            if (hasGrades && obsInput.value.trim() === '') {
                allValid = false;
            }
        });

        saveBtn.disabled = !anyChanges || !allValid;
        editWarning.style.display = (anyChanges && !allValid) ? 'inline' : 'none';
    }

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            calculateRow(this.dataset.student);
        });
    });

    document.querySelectorAll('.obs-input').forEach(input => {
        input.addEventListener('input', function() {
            const studentId = this.id.replace('obs-', '');
            calculateRow(studentId);
        });
    });

    window.enableEdit = function(studentId) {
        const row = document.getElementById(`row-${studentId}`);
        const inputs = row.querySelectorAll('.nota-input, .obs-input');
        const btn = row.querySelector('.edit-btn');

        row.classList.add('row-editing', 'table-primary');
        row.style.backgroundColor = 'rgba(13, 110, 253, 0.1)';
        
        inputs.forEach(input => {
            input.readOnly = false;
            input.classList.remove('border-0');
            input.classList.add('border-secondary');
        });

        btn.classList.remove('btn-outline-info');
        btn.classList.add('btn-info');
        btn.innerHTML = '<i class="fa fa-unlock"></i> Editando';
        btn.disabled = true;

        validateForm();
    };
});

function submitPromotion(type) {
    const form = document.getElementById('promote-form');
    const container = document.getElementById('selected-students-container');
    container.innerHTML = '';
    
    let selectedIds = [];
    let ineligibleStudents = [];
    
    if (type === 'manual') {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        if (checked.length === 0) {
            alert('Por favor seleccione al menos un estudiante.');
            return;
        }
        
        checked.forEach(cb => {
            if (cb.dataset.apto === '1') {
                selectedIds.push(cb.value);
            } else {
                ineligibleStudents.push(cb.dataset.nombre);
            }
        });

        if (ineligibleStudents.length > 0) {
            alert('Los siguientes estudiantes no son aptos para promoción (Nota < 3.0 o sin notas):\n- ' + ineligibleStudents.join('\n- '));
            if (selectedIds.length === 0) return;
            if (!confirm('¿Desea continuar promoviendo solo a los estudiantes aptos?')) return;
        }
    } else {
        const all = document.querySelectorAll('.student-checkbox');
        all.forEach(cb => {
            if (cb.dataset.apto === '1') {
                selectedIds.push(cb.value);
            }
        });

        if (selectedIds.length === 0) {
            alert('No hay estudiantes aptos para promoción en este grupo.');
            return;
        }

        if (!confirm('Se promoverán ' + selectedIds.length + ' estudiantes aptos. ¿Está seguro?')) return;
    }

    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'estudiantes[]';
        input.value = id;
        container.appendChild(input);
    });

    form.submit();
}
</script>
@endsection
