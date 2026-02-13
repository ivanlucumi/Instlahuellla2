<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre del Grado</label>
        <input type="text"
               name="nombre_grado"
               class="form-control @error('nombre_grado') is-invalid @enderror"
               value="{{ old('nombre_grado', $gradoAcademico->nombre_grado ?? '') }}"
               required>
        @error('nombre_grado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Bloque / Sección</label>
        <input type="text"
               name="bloque"
               class="form-control @error('bloque') is-invalid @enderror"
               value="{{ old('bloque', $gradoAcademico->bloque ?? '') }}"
               required>
        @error('bloque')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sede</label>
        <select name="sede_id" 
                class="form-select @error('sede_id') is-invalid @enderror" 
                required>
            <option value="">Seleccione una sede</option>
            @foreach($sedes as $sede)
                <option value="{{ $sede->id }}"
                    @selected(old('sede_id', $gradoAcademico->sede_id ?? '') == $sede->id)>
                    {{ $sede->nombre_sede }}
                </option>
            @endforeach
        </select>
        @error('sede_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Director de Grado (Docente)</label>
        <select name="docente_id" 
                class="form-select @error('docente_id') is-invalid @enderror" 
                required>
            <option value="">Seleccione un docente</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}"
                    @selected(old('docente_id', $gradoAcademico->docente_id ?? '') == $docente->id)>
                    {{ $docente->user->name ?? 'N/A' }}
                </option>
            @endforeach
        </select>
        @error('docente_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Curso</label>
        <select name="curso_id" 
                class="form-select @error('curso_id') is-invalid @enderror">
            <option value="">Seleccione un curso (Opcional)</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->id }}"
                    @selected(old('curso_id', $gradoAcademico->curso_id ?? '') == $curso->id)>
                    {{ $curso->nombre_curso }}
                </option>
            @endforeach
        </select>
        @error('curso_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Asignatura</label>
        <select name="asignatura_id" 
                class="form-select @error('asignatura_id') is-invalid @enderror">
            <option value="">Seleccione una asignatura (Opcional)</option>
            @foreach($asignaturas as $asignatura)
                <option value="{{ $asignatura->id }}"
                    @selected(old('asignatura_id', $gradoAcademico->asignatura_id ?? '') == $asignatura->id)>
                    {{ $asignatura->nombre_asignatura }} ({{ $asignatura->hilo->nombre_hilo ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('asignatura_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <div class="form-check form-switch">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="estado_grado_academico" 
                   id="estado_grado_academico"
                   value="1"
                   @checked(old('estado_grado_academico', $gradoAcademico->estado_grado_academico ?? true))>
            <label class="form-check-label" for="estado_grado_academico">
                Grado Activo
            </label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.gradoacademico.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
