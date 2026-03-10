@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label text-white">Nombre Completo</label>
        <input type="text" name="name" id="name" class="form-control bg-dark text-white @error('name') is-invalid @enderror" 
               value="{{ old('name', $user->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label text-white">Correo Electrónico</label>
        <input type="email" name="email" id="email" class="form-control bg-dark text-white @error('email') is-invalid @enderror" 
               value="{{ old('email', $user->email ?? '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="password" class="form-label text-white">Contraseña {{ isset($user) ? '(Dejar en blanco para no cambiar)' : '' }}</label>
        <input type="password" name="password" id="password" class="form-control bg-dark text-white @error('password') is-invalid @enderror" 
               {{ isset($user) ? '' : 'required' }}>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="password_confirmation" class="form-label text-white">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-dark text-white" 
               {{ isset($user) ? '' : 'required' }}>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="genero" class="form-label text-white">Género</label>
        <select name="genero" id="genero" class="form-select @error('genero') is-invalid @enderror">
            <option value="">Seleccione...</option>
            <option value="Masculino" {{ old('genero', $user->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Femenino" {{ old('genero', $user->genero ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
            <option value="otro" {{ old('genero', $user->genero ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
        </select>
        @error('genero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="roles" class="form-label text-white">Roles</label>
        <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror" multiple="multiple">
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}" 
                    {{ (collect(old('roles'))->contains($rol->id) || (isset($user) && $user->roles->contains($rol->id))) ? 'selected' : '' }}>
                    {{ $rol->nombre }}
                </option>
            @endforeach
        </select>
        @error('roles')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Mantenga presionada la tecla Ctrl para seleccionar varios.</small>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-end">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fa fa-save me-1"></i> Guardar Usuario
        </button>
    </div>
</div>
