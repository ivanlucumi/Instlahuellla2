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
        <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
            @if($esAnoActual && $canEdit)
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="enableMassEdit()">
                    <i class="fa fa-edit me-1"></i> Habilitar Edición Masiva
                </button>
            @endif
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
                                    @php
                                        $userObj = auth()->user();
                                        $isAdmin = $userObj->hasRol('SUPERADMIN') || $userObj->hasRol('RECTOR');
                                    @endphp
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
                                        <input type="hidden" name="ano_lectivo" value="{{ $anoLectivo }}">
                                        <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                                        <input type="hidden" name="grado_origen_id" value="{{ $grado->id }}">
                                    <div id="selected-students-container"></div>
                                    
                                            <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-dark small fw-bold">Grado Destino (Promovidos)</label>
                                                <select name="grado_destino_id" class="form-select border-0 shadow-sm" required>
                                                    <option value="">Seleccione curso superior...</option>
                                                    @foreach($todosLosGrados as $g)
                                                        <option value="{{ $g->id }}">{{ $g->nombre_grado }} - {{ $g->bloque }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-text mt-2"><i class="bi bi-info-circle"></i> Los estudiantes NO promovidos permanecerán en el grado actual automáticamente en el año siguiente ({{ (intval($anoLectivo) + 1) }}).</div>
                                            </div>
                                            <div class="col-md-6 mt-4 d-flex justify-content-end align-items-start gap-2">
                                                <button type="button" onclick="submitPromotion('manual')" class="btn btn-dark rounded-pill px-4">
                                                    <i class="bi bi-person-check me-1"></i> Promover (Manual)
                                                </button>
                                                <button type="button" onclick="submitPromotion('total')" class="btn btn-outline-dark rounded-pill px-4">
                                                    <i class="bi bi-people-fill me-1"></i> Promover Inteligente (x Notas)
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

        // Requerir observaciones y habilitarlo SOLO si P3 tiene nota
        const isEditingRow = row.classList.contains('row-editing');
        
        if (n3 > 0) {
            if (isEditingRow) {
                obsInput.readOnly = false;
                obsInput.classList.remove('bg-light');
                obsInput.classList.add('bg-white');
            }
            if (obsInput.value.trim() === '') {
                obsInput.classList.add('border', 'border-warning');
                obsInput.classList.remove('border-0', 'border-secondary');
            } else {
                obsInput.classList.remove('border', 'border-warning');
                obsInput.classList.add('border-0');
            }
        } else {
            obsInput.readOnly = true;
            obsInput.classList.add('bg-light', 'border-0');
            obsInput.classList.remove('bg-white', 'border', 'border-warning', 'border-secondary');
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
            const n3Val = parseFloat(row.querySelector(`input[name="notas[${studentId}][nota3]"]`).value) || 0;
            const obsInput = row.querySelector('.obs-input');
            
            if (n3Val > 0 && obsInput.value.trim() === '') {
                allValid = false;
            }
        });

        saveBtn.disabled = !anyChanges || !allValid;
        editWarning.style.display = (anyChanges && !allValid) ? 'inline' : 'none';
        if (anyChanges && !allValid) {
            editWarning.innerHTML = '<i class="bi bi-info-circle me-1 text-warning"></i> Complete las observaciones en P3 para guardar.';
        }
    }

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (parseFloat(this.value) > 5) {
                this.value = '5.0';
            }
            calculateRow(this.dataset.student);
        });
    });

    document.querySelectorAll('.obs-input').forEach(input => {
        input.addEventListener('input', function() {
            const studentId = this.id.replace('obs-', '');
            calculateRow(studentId);
        });
    });

    window.enableMassEdit = function() {
        checkboxes.forEach(cb => {
            enableEdit(cb.value);
        });
        const btn = event.currentTarget;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-check-circle"></i> Edición Habilitada';
    };

    window.enableEdit = function(studentId) {
        const row = document.getElementById(`row-${studentId}`);
        const inputs = row.querySelectorAll('.nota-input');
        const obsInput = row.querySelector('.obs-input');
        const btn = row.querySelector('.edit-btn');
        const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

        row.classList.add('row-editing', 'table-primary');
        row.style.backgroundColor = 'rgba(13, 110, 253, 0.05)';
        
        let firstEmptyFound = false;
        
        inputs.forEach((input, index) => {
            const hasValue = parseFloat(input.value) > 0;
            
            if (isAdmin) {
                // Admin puede editar todo lo que no sea histórico
                input.readOnly = false;
                input.classList.remove('bg-light', 'border-0');
                input.classList.add('bg-white', 'border-secondary');
            } else {
                // Docente: solo el primer vacío si los anteriores están llenos
                if (!hasValue && !firstEmptyFound) {
                    // Verificar si es el primero o si el anterior tiene valor
                    let canEnable = true;
                    if (index > 0) {
                        const prevInput = inputs[index-1];
                        if (!(parseFloat(prevInput.value) > 0)) {
                            canEnable = false;
                        }
                    }
                    
                    if (canEnable) {
                        input.readOnly = false;
                        input.classList.remove('bg-light', 'border-0');
                        input.classList.add('bg-white', 'border-primary', 'border-2');
                        input.style.boxShadow = '0 0 0 0.2rem rgba(13, 110, 253, 0.1)';
                        firstEmptyFound = true;
                    }
                } else {
                    input.readOnly = true;
                    input.classList.add('bg-light', 'text-muted');
                    input.style.opacity = '0.7';
                }
            }
        });

        if (btn) {
            btn.innerHTML = '<i class="fa fa-unlock"></i> Editando';
            btn.disabled = true;
            btn.classList.add('text-muted');
        }

        // Trigger calculaterow to update visual state correctly based on P3 dynamically
        calculateRow(studentId);
    };
});

function submitPromotion(type) {
    const form = document.getElementById('promote-form');
    const container = document.getElementById('selected-students-container');
    container.innerHTML = '';
    
    const gradoDestino = form.querySelector('[name="grado_destino_id"]').value;

    if (!gradoDestino) {
        alert('Por favor seleccione el Grado Destino para los promovidos.');
        return;
    }

    let promovidos = [];
    let reprobados = [];
    let ineligibleStudents = [];
    
    if (type === 'manual') {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        if (checked.length === 0 && !confirm('No ha seleccionado ningún estudiante para promover. ¿Desea continuar registrando a todos como NO promovidos?')) {
            return;
        }
        
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            if (cb.checked) {
                if (cb.dataset.apto === '1') {
                    promovidos.push(cb.value);
                } else {
                    ineligibleStudents.push(cb.dataset.nombre);
                    // Los forzamos a repetidores si no cumplen, a pesar de estar chuleados?
                    // Según instrucción, solo validamos advertencia
                }
            } else {
                reprobados.push(cb.value);
            }
        });

        if (ineligibleStudents.length > 0) {
            alert('ADVERTENCIA: Ha seleccionado estudiantes que no cumplen con la nota (menor a 3.0):\n- ' + ineligibleStudents.join('\n- '));
            if (!confirm('¿Desea CUALQUIER MODO promoverlos? Si elige Cancelar, detendremos la operación.')) {
                return;
            } else {
                // If they confirm, we add them to promovidos
                document.querySelectorAll('.student-checkbox:checked').forEach(cb => {
                    if (cb.dataset.apto !== '1') promovidos.push(cb.value);
                });
            }
        }
    } else {
        // Total - Inteligente
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            if (cb.dataset.apto === '1') {
                promovidos.push(cb.value);
            } else {
                reprobados.push(cb.value);
            }
        });

        if (!confirm(`Se promoverán automáticamente ${promovidos.length} estudiantes aprobados y ${reprobados.length} estudiantes repetirán el año. ¿Está seguro?`)) {
            return;
        }
    }

    promovidos.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'estudiantes_promovidos[]';
        input.value = id;
        container.appendChild(input);
    });

    reprobados.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'estudiantes_reprobados[]';
        input.value = id;
        container.appendChild(input);
    });

    form.submit();
}
</script>
@endsection
