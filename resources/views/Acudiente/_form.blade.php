<div class="row">
    {{-- Campos de Usuario --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" name="name" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $acudiente->user->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Correo Electrónico</label>
        <input type="email" name="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $acudiente->user->email ?? '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Celular</label>
        <input type="text"
               name="celular_acudiente"
               class="form-control @error('celular_acudiente') is-invalid @enderror"
               value="{{ old('celular_acudiente', $acudiente->celular_acudiente ?? '') }}"
               required>
        @error('celular_acudiente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Dirección</label>
        <input type="text"
               name="direccion_acudiente"
               class="form-control @error('direccion_acudiente') is-invalid @enderror"
               value="{{ old('direccion_acudiente', $acudiente->direccion_acudiente ?? '') }}"
               required>
        @error('direccion_acudiente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Parentesco</label>
        <input type="text"
               name="parentesco_acudiente"
               class="form-control @error('parentesco_acudiente') is-invalid @enderror"
               value="{{ old('parentesco_acudiente', $acudiente->parentesco_acudiente ?? '') }}"
               required>
        @error('parentesco_acudiente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Género</label>
        <select name="genero_acudiente" class="form-select @error('genero_acudiente') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach(['Masculino', 'Femenino', 'Otro'] as $gen)
                <option value="{{ $gen }}" @selected(old('genero_acudiente', $acudiente->genero_acudiente ?? '') == $gen)>
                    {{ $gen }}
                </option>
            @endforeach
        </select>
        @error('genero_acudiente')
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
                   name="estado_acudiente" 
                   id="estado_acudiente"
                   value="1"
                   @checked(old('estado_acudiente', $acudiente->estado_acudiente ?? true))>
            <label class="form-check-label" for="estado_acudiente">
                Acudiente Activo
            </label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.acudiente.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
