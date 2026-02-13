<div class="row">
    {{-- Campos de Usuario --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" name="name" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $docente->user->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Correo Electrónico</label>
        <input type="email" name="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $docente->user->email ?? '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Código Docente</label>
        <input type="text"
               name="codigo_docente"
               class="form-control @error('codigo_docente') is-invalid @enderror"
               value="{{ old('codigo_docente', $docente->codigo_docente ?? '') }}"
               required>
        @error('codigo_docente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Género</label>
        <select name="genero_docente" class="form-select @error('genero_docente') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach(['Masculino', 'Femenino', 'Otro'] as $gen)
                <option value="{{ $gen }}" @selected(old('genero_docente', $docente->genero_docente ?? '') == $gen)>
                    {{ $gen }}
                </option>
            @endforeach
        </select>
        @error('genero_docente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Foto del Docente</label>
        <input type="file"
               name="foto_docente"
               class="form-control @error('foto_docente') is-invalid @enderror"
               accept="image/*">
        @error('foto_docente')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
        @if(isset($docente) && $docente->foto_docente && $docente->foto_docente !== 'default.png')
            <div class="mt-2">
                <img src="{{ asset('storage/' . $docente->foto_docente) }}" 
                     alt="Foto actual" 
                     class="rounded"
                     width="100">
                <p class="text-muted small mt-1">Foto actual</p>
            </div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <div class="form-check form-switch">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="estado_docente" 
                   id="estado_docente"
                   value="1"
                   @checked(old('estado_docente', $docente->estado_docente ?? true))>
            <label class="form-check-label" for="estado_docente">
                Docente Activo
            </label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.docente.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
