<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre de la Asignatura</label>
        <input type="text"
               name="nombre_asignatura"
               class="form-control @error('nombre_asignatura') is-invalid @enderror"
               value="{{ old('nombre_asignatura', $asignatura->nombre_asignatura ?? '') }}"
               required>
        @error('nombre_asignatura')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nivel Educativo</label>
        <select name="nivel_educativo" 
                class="form-select @error('nivel_educativo') is-invalid @enderror" 
                required>
            <option value="">Seleccione un nivel</option>
            <option value="primaria" 
                @selected(old('nivel_educativo', $asignatura->nivel_educativo ?? '') == 'primaria')>
                Primaria
            </option>
            <option value="secundaria" 
                @selected(old('nivel_educativo', $asignatura->nivel_educativo ?? '') == 'secundaria')>
                Secundaria
            </option>
        </select>
        @error('nivel_educativo')
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
                    @selected(old('sede_id', $asignatura->sede_id ?? '') == $sede->id)>
                    {{ $sede->nombre_sede }}
                </option>
            @endforeach
        </select>
        @error('sede_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Hilo</label>
        <select name="hilo_id" 
                class="form-select @error('hilo_id') is-invalid @enderror" 
                required>
            <option value="">Seleccione un hilo</option>
            @foreach($hilos as $hilo)
                <option value="{{ $hilo->id }}"
                    @selected(old('hilo_id', $asignatura->hilo_id ?? '') == $hilo->id)>
                    {{ $hilo->nombre_hilo }} ({{ $hilo->abreviatura }})
                </option>
            @endforeach
        </select>
        @error('hilo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Docente Responsable</label>
        <select name="docente_id" 
                class="form-select @error('docente_id') is-invalid @enderror" 
                required>
            <option value="">Seleccione un docente</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}"
                    @selected(old('docente_id', $asignatura->docente_id ?? '') == $docente->id)>
                    {{ $docente->name }}
                </option>
            @endforeach
        </select>
        @error('docente_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Grado Académico (Opcional)</label>
        <select name="grado_id" 
                class="form-select @error('grado_id') is-invalid @enderror">
            <option value="">Asignatura General (Sin grado específico)</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->id }}"
                    @selected(old('grado_id', $asignatura->grado_id ?? '') == $grado->id)>
                    {{ $grado->nombre_grado }} - {{ $grado->bloque }} ({{ $grado->sede->nombre_sede ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        <small class="text-muted">Asigne un grado si esta asignatura es específica para uno.</small>
        @error('grado_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion"
                  class="form-control @error('descripcion') is-invalid @enderror"
                  rows="3"
                  required>{{ old('descripcion', $asignatura->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Créditos</label>
        <input type="number"
               name="creditos"
               class="form-control @error('creditos') is-invalid @enderror"
               value="{{ old('creditos', $asignatura->creditos ?? '') }}"
               min="1"
               max="10"
               required>
        <small class="text-muted">Entre 1 y 10 créditos</small>
        @error('creditos')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" 
                class="form-select @error('estado') is-invalid @enderror" 
                required>
            <option value="activo" @selected(old('estado', $asignatura->estado ?? 'activo') == 'activo')>
                Activo
            </option>
            <option value="inactivo" @selected(old('estado', $asignatura->estado ?? '') == 'inactivo')>
                Inactivo
            </option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.asignatura.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
