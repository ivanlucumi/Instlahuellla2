@extends('layouts.Administracion')

@section('title', 'Editar Grado Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Grado: {{ $gradoAcademico->nombre_grado }}</h6>
            
            <form action="{{ route('admin.gradoacademico.update', $gradoAcademico->id) }}" method="POST" id="grado-form">
                @csrf
                @method('PUT')
                @include('GradoAcademico._form', ['isEdit' => true])

                <hr class="my-4 border-secondary">
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-white mb-0"><i class="fa fa-book me-2 text-primary"></i>Asignaturas y Docentes Especialistas</h6>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSubjectRow()">
                        <i class="fa fa-plus me-1"></i> Vincular Materia
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="subjects-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45%;">Asignatura y Nivel</th>
                                <th style="width: 45%;">Docente que dicta la materia</th>
                                <th class="text-center" style="width: 10%;">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="subjects-container">
                            @foreach($gradoAcademico->asignaturas as $index => $asig)
                                <tr class="subject-row">
                                    <td>
                                        <select name="asignaturas[{{ $index }}][id]" class="form-select bg-dark text-white border-secondary select-asig" required>
                                            <option value="">Seleccione materia...</option>
                                            @foreach($asignaturas as $a)
                                                <option value="{{ $a->id }}" @selected($a->id == $asig->id)>
                                                    {{ $a->nombre_asignatura }} - {{ $a->nivel_educativo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="asignaturas[{{ $index }}][docente_id]" class="form-select bg-dark text-white border-secondary">
                                            <option value="">Seleccione docente...</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}" @selected($u->id == ($asig->pivot->docente_id ?? null))>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-top pt-3 border-secondary">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Guardar Todo el Grado
                    </button>
                    <a href="{{ route('admin.gradoacademico.index') }}" class="btn btn-warning ms-2">
                        <i class="fa fa-times me-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="subject-row-template">
    <tr class="subject-row">
        <td>
            <select name="asignaturas[INDEX][id]" class="form-select bg-dark text-white border-secondary select-asig" required>
                <option value="">Seleccione materia...</option>
                @foreach($asignaturas as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->nombre_asignatura }} - {{ $a->nivel_educativo }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="asignaturas[INDEX][docente_id]" class="form-select bg-dark text-white border-secondary">
                <option value="">Seleccione docente...</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-btn">
                <i class="fa fa-times"></i>
            </button>
        </td>
    </tr>
</template>

<script>
    let subjectIndex = {{ $gradoAcademico->asignaturas->count() }};
    
    // Pass subjects data to JS for level lookup
    const asignaturasData = @json($asignaturas->map(function($a){ return ['id' => $a->id, 'nivel' => $a->nivel_educativo]; }));

    document.addEventListener('DOMContentLoaded', function() {
        updateSubjectOptions();
        
        // Initialize rows styles on load
        document.querySelectorAll('.select-asig').forEach(select => {
            updateRowStyle(select);
        });
    });

    function addSubjectRow() {
        const container = document.getElementById('subjects-container');
        const template = document.getElementById('subject-row-template').innerHTML;
        const newRowContent = template.replace(/INDEX/g, subjectIndex++);
        
        const tr = document.createElement('tr');
        tr.className = 'subject-row';
        tr.innerHTML = newRowContent;
        container.appendChild(tr);

        updateSubjectOptions();
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select-asig')) {
            updateSubjectOptions();
            updateRowStyle(e.target);
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-btn')) {
            e.target.closest('tr').remove();
            updateSubjectOptions();
        }
    });

    function updateRowStyle(selectElement) {
        const selectedId = parseInt(selectElement.value);
        if(!selectedId) return;

        const subject = asignaturasData.find(a => a.id === selectedId);
        const tr = selectElement.closest('tr');
        
        // Remove existing badge if any
        const existingBadge = tr.querySelector('.level-badge');
        if(existingBadge) existingBadge.remove();

        if (subject) {
            const badge = document.createElement('span');
            badge.className = 'level-badge badge ms-2 ' + (subject.nivel === 'PRIMARIA' ? 'bg-info text-dark' : 'bg-warning text-dark');
            badge.innerText = subject.nivel;
            
            // Append badge after the select
            if(selectElement.nextSibling) {
                selectElement.parentNode.insertBefore(badge, selectElement.nextSibling);
            } else {
                selectElement.parentNode.appendChild(badge);
            }
            
            // Optional: color the row slightly
            tr.className = 'subject-row ' + (subject.nivel === 'PRIMARIA' ? 'table-info' : 'table-warning');
        } else {
             tr.className = 'subject-row';
        }
    }

    function updateSubjectOptions() {
        const selects = document.querySelectorAll('.select-asig');
        const selectedValues = Array.from(selects).map(s => s.value).filter(v => v);

        selects.forEach(select => {
            const currentVal = select.value;
            Array.from(select.options).forEach(option => {
                if (option.value === "") return;
                
                // Reset text first
                option.innerText = option.innerText.replace(' (Seleccionada)', '');

                // Disable if selected elsewhere
                if (selectedValues.includes(option.value) && option.value !== currentVal) {
                    option.disabled = true;
                    option.innerText += ' (Seleccionada)';
                } else {
                    option.disabled = false;
                }
            });
        });
    }
</script>

@endsection
