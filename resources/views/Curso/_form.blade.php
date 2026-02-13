<div class="mb-3">
    <label class="form-label">Nombre del Curso</label>
    <input type="text"
           name="nombre_curso"
           class="form-control @error('nombre_curso') is-invalid @enderror"
           value="{{ old('nombre_curso', $curso->nombre_curso ?? '') }}"
           required>
    @error('nombre_curso')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion"
              class="form-control @error('descripcion') is-invalid @enderror"
              rows="4"
              required>{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Estado</label>
    <select name="estado" 
            class="form-select @error('estado') is-invalid @enderror" 
            required>
        <option value="activo" @selected(old('estado', $curso->estado ?? 'activo') == 'activo')>
            Activo
        </option>
        <option value="inactivo" @selected(old('estado', $curso->estado ?? '') == 'inactivo')>
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

    <a href="{{ route('admin.curso.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
