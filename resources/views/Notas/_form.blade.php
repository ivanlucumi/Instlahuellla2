<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Periodo Académico</label>
        <select name="periodo_academico_id" class="form-select @error('periodo_academico_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($periodos as $periodo)
                <option value="{{ $periodo->id }}" @selected(old('periodo_academico_id', $nota->periodo_academico_id ?? '') == $periodo->id)>
                    {{ $periodo->nombre_periodo }}
                </option>
            @endforeach
        </select>
        @error('periodo_academico_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Grado</label>
        <select name="grado_id" class="form-select @error('grado_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->id }}" @selected(old('grado_id', $nota->grado_id ?? '') == $grado->id)>
                    {{ $grado->nombre_grado }}
                </option>
            @endforeach
        </select>
        @error('grado_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estudiante</label>
        <select name="estudiante_id" class="form-select @error('estudiante_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($estudiantes as $estudiante)
                <option value="{{ $estudiante->id }}" @selected(old('estudiante_id', $nota->estudiante_id ?? '') == $estudiante->id)>
                    {{ $estudiante->user->name ?? 'Sin nombre' }} ({{ $estudiante->codigo_estudiante }})
                </option>
            @endforeach
        </select>
        @error('estudiante_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Asignatura</label>
        <select name="asignatura_id" class="form-select @error('asignatura_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($asignaturas as $asignatura)
                <option value="{{ $asignatura->id }}" @selected(old('asignatura_id', $nota->asignatura_id ?? '') == $asignatura->id)>
                    {{ $asignatura->nombre_asignatura }}
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
        <label class="form-label">Nota</label>
        <input type="number" step="0.01" min="0" max="5" name="nota" 
               class="form-control @error('nota') is-invalid @enderror" 
               value="{{ old('nota', $nota->nota ?? '') }}" required>
        @error('nota')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Observaciones</label>
        <input type="text" name="observaciones" 
               class="form-control @error('observaciones') is-invalid @enderror" 
               value="{{ old('observaciones', $nota->observaciones ?? '') }}">
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.notas.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
