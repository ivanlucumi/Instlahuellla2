<div class="mb-3">
    <label class="form-label">Nombre del Hilo</label>
    <input type="text"
           name="nombre_hilo"
           class="form-control @error('nombre_hilo') is-invalid @enderror"
           value="{{ old('nombre_hilo', $hilo->nombre_hilo ?? '') }}"
           required>
    @error('nombre_hilo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Abreviatura</label>
    <input type="text"
           name="abreviatura"
           class="form-control @error('abreviatura') is-invalid @enderror"
           value="{{ old('abreviatura', $hilo->abreviatura ?? '') }}"
           maxlength="10"
           required>
    <small class="text-muted">Máximo 10 caracteres</small>
    @error('abreviatura')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Estado</label>
    <select name="estado" 
            class="form-select @error('estado') is-invalid @enderror" 
            required>
        <option value="activo" @selected(old('estado', $hilo->estado ?? 'activo') == 'activo')>
            Activo
        </option>
        <option value="inactivo" @selected(old('estado', $hilo->estado ?? '') == 'inactivo')>
            Inactivo
        </option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.hilo.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
