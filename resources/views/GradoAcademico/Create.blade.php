@extends('layouts.Administracion')

@section('title', 'Crear Grado Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Grado Académico</h6>
            
            <form action="{{ route('admin.gradoacademico.store') }}" method="POST" id="grado-form">
                @csrf
                @include('GradoAcademico._form', ['isEdit' => false])

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
                            {{-- Se cargarán dinámicamente --}}
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-top pt-3 border-secondary">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Crear Grado
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
    let subjectIndex = 0;
    
    // Pass subjects data to JS for level lookup
    const asignaturasData = @json($asignaturas->map(function($a){ return ['id' => $a->id, 'nivel' => $a->nivel_educativo]; }));

    function addSubjectRow() {
        const container = document.getElementById('subjects-container');
        const template = document.getElementById('subject-row-template').innerHTML;
        const newRowContent = template.replace(/INDEX/g, subjectIndex++);
        
        const tr = document.createElement('tr');
        tr.className = 'subject-row';
        tr.innerHTML = newRowContent;
        container.appendChild(tr);

        // Re-evaluate options
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
            selectElement.parentNode.insertBefore(badge, selectElement.nextSibling);
            
            // Optional: color the row slightly
            tr.className = 'subject-row ' + (subject.nivel === 'PRIMARIA' ? 'table-info' : 'table-warning');
            // Remove bootstrap table-striped or similar if it conflicts, but table-info/warning should work
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
                // Disable if selected elsewhere, but not if it's the current value of this select
                if (selectedValues.includes(option.value) && option.value !== currentVal) {
                    option.disabled = true;
                    option.innerText = option.innerText.replace(' (Seleccionada)', '') + ' (Seleccionada)';
                } else {
                    option.disabled = false;
                    option.innerText = option.innerText.replace(' (Seleccionada)', '');
                }
            });
        });
    }
</script>

@endsection
