@extends('layouts.Administracion')

@section('title', 'Estudiantes - ' . $asignatura->nombre_asignatura)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white">{{ $asignatura->nombre_asignatura }}</h4>
                    <p class="text-primary mb-0 fw-bold">
                        <i class="fa fa-users me-1"></i> Grado: {{ $grado->nombre_grado }} - {{ $grado->bloque }}
                    </p>
                    <p class="text-muted mb-0 small">
                        <span class="badge bg-info">{{ $asignatura->hilo->nombre_hilo ?? 'N/A' }}</span> | 
                        Sede: {{ $asignatura->sede->nombre_sede ?? 'N/A' }}
                    </p>
                </div>
                <a href="{{ route('docente.dashboard') }}" class="btn btn-warning">
                    <i class="fa fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <form action="{{ route('docente.notas.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                    <input type="hidden" name="grado_id" value="{{ $grado->id }}">
                    
                    <div class="table-responsive">
                        <table class="table table-hover text-white">
                            <thead>
                                <tr>
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
                                    @endphp
                                    <tr id="row-{{ $estudiante->id }}">
                                        <td>
                                            @php
                                                $definitiva = $notaObj->nota_definitiva ?? 0;
                                                $isApto = ($notaObj && $definitiva >= 3);
                                            @endphp
                                            <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->id }}" 
                                                class="form-check-input student-checkbox" 
                                                data-apto="{{ $isApto ? '1' : '0' }}"
                                                data-nombre="{{ $estudiante->user->name }}">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white">
                                                {{ $estudiante->user->name }}
                                                @if(!$isApto)
                                                    <i class="bi bi-exclamation-circle-fill text-danger ms-1" title="No apto para promoción (Nota < 3.0 o sin notas)"></i>
                                                @else
                                                    <i class="bi bi-check-circle-fill text-success ms-1" title="Apto para promoción"></i>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $estudiante->numero_identificacion_estudiante }}</small>
                                        </td>
                                        <td style="width: 80px;">
                                            <input type="number" name="notas[{{ $estudiante->id }}][nota1]" class="form-control form-control-sm text-center nota-input bg-dark text-white border-0" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota1 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                        </td>
                                        <td style="width: 80px;">
                                            <input type="number" name="notas[{{ $estudiante->id }}][nota2]" class="form-control form-control-sm text-center nota-input bg-dark text-white border-0" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota2 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                        </td>
                                        <td style="width: 80px;">
                                            <input type="number" name="notas[{{ $estudiante->id }}][nota3]" class="form-control form-control-sm text-center nota-input bg-dark text-white border-0" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota3 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                        </td>
                                        <td style="width: 80px;">
                                            <input type="number" name="notas[{{ $estudiante->id }}][nota4]" class="form-control form-control-sm text-center nota-input bg-dark text-white border-0" data-student="{{ $estudiante->id }}" value="{{ $notaObj->nota4 ?? '' }}" min="0" max="5" step="0.1" readonly>
                                        </td>
                                        <td class="text-center fw-bold">
                                            <span id="def-{{ $estudiante->id }}" class="badge def-badge {{ $definitiva >= 3 ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($definitiva, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" name="notas[{{ $estudiante->id }}][observaciones]" id="obs-{{ $estudiante->id }}" class="form-control form-control-sm bg-dark text-white border-0 obs-input" value="{{ $notaObj->observaciones ?? '' }}" placeholder="Nota o comentario..." readonly>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-info edit-btn" onclick="enableEdit('{{ $estudiante->id }}')">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex align-items-center">
                        <button type="submit" class="btn btn-primary" id="save-btn" disabled>
                            <i class="bi bi-save me-1"></i> Guardar Calificaciones
                        </button>
                        <span class="ms-3 text-warning small" id="edit-warning" style="display: none;">
                            <i class="bi bi-exclamation-triangle me-1"></i> Recuerde que las observaciones son obligatorias al ingresar notas.
                        </span>
                    </div>
                </form>

                @if($all_graded)
                <hr class="my-5 border-light">

                <div class="card bg-dark border-secondary shadow">
                    <div class="card-header border-secondary bg-primary bg-gradient text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-mortarboard-fill me-2"></i> Promover Estudiantes a Grado Superior
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-4">
                            <i class="bi bi-info-circle me-1 text-info"></i> 
                            Todos los estudiantes han sido calificados. Ahora puede proceder con la promoción de aquellos que aprobaron (nota >= 3.0).
                        </p>
                        
                        <form action="{{ route('docente.estudiantes.promover') }}" method="POST" id="promote-form">
                            @csrf
                            <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                            <input type="hidden" name="grado_origen_id" value="{{ $grado->id }}">
                            <div id="selected-students-container"></div>
                            
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label text-white small">Seleccione el Grado de Destino (Año Superior)</label>
                                    <select name="grado_destino_id" class="form-select bg-dark text-white border-secondary" required>
                                        <option value="">Seleccione el grado...</option>
                                        @foreach($todosLosGrados as $g)
                                            <option value="{{ $g->id }}">{{ $g->nombre_grado }} - {{ $g->bloque }} ({{ $g->sede->nombre_sede ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <button type="button" onclick="submitPromotion('manual')" class="btn btn-warning">
                                        <i class="bi bi-person-check me-1"></i> Promover Seleccionados
                                    </button>
                                    <button type="button" onclick="submitPromotion('total')" class="btn btn-danger ms-2">
                                        <i class="bi bi-people-fill me-1"></i> Promover Grupo Apto
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info mt-5 border-info bg-dark-info" style="border-left: 5px solid;">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Sección de Promoción:</strong> Para habilitar la promoción de estudiantes, primero debe calificar a <strong>todos</strong> los estudiantes con su nota definitiva.
                </div>
                @endif
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
        
        let sum = 0;
        let count = 0;
        let hasValue = false;
        
        studentInputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val) && input.value !== '') {
                sum += val;
                count++;
                hasValue = true;
            }
        });

        if (count > 0) {
            const avg = sum / count;
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

            // Requerir observaciones visualmente
            if (obsInput.value.trim() === '') {
                obsInput.classList.add('border', 'border-warning');
                obsInput.classList.remove('border-0');
            } else {
                obsInput.classList.remove('border', 'border-warning');
                obsInput.classList.add('border-0');
            }
        } else {
            badge.textContent = '0.00';
            badge.classList.remove('bg-success');
            badge.classList.add('bg-danger');
            checkbox.dataset.apto = '0';
            const icon = row.querySelector('.bi-exclamation-circle-fill, .bi-check-circle-fill');
            if (icon) {
                icon.className = 'bi bi-exclamation-circle-fill text-danger ms-1';
                icon.title = 'No apto para promoción (Sin notas)';
            }
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
