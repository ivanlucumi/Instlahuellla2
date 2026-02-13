<div class="row">
    {{-- Campos de Usuario --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" name="name" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $estudiante->user->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Correo Electrónico</label>
        <input type="email" name="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $estudiante->user->email ?? '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Código Estudiantil</label>
        <input type="text" name="codigo_estudiante" class="form-control @error('codigo_estudiante') is-invalid @enderror" 
               value="{{ old('codigo_estudiante', $estudiante->codigo_estudiante ?? '') }}" required>
        @error('codigo_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Foto</label>
        <input type="file" name="foto_estudiante" class="form-control @error('foto_estudiante') is-invalid @enderror">
        @error('foto_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento_estudiante" class="form-control @error('fecha_nacimiento_estudiante') is-invalid @enderror" 
               value="{{ old('fecha_nacimiento_estudiante', isset($estudiante) ? $estudiante->fecha_nacimiento_estudiante->format('Y-m-d') : '') }}" required>
        @error('fecha_nacimiento_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Género</label>
        <select name="genero_estudiante" class="form-select @error('genero_estudiante') is-invalid @enderror" required>
            <option value="">Seleccione género</option>
            <option value="Masculino" @selected(old('genero_estudiante', $estudiante->genero_estudiante ?? '') == 'Masculino')>Masculino</option>
            <option value="Femenino" @selected(old('genero_estudiante', $estudiante->genero_estudiante ?? '') == 'Femenino')>Femenino</option>
            <option value="Otro" @selected(old('genero_estudiante', $estudiante->genero_estudiante ?? '') == 'Otro')>Otro</option>
        </select>
        @error('genero_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Grado Académico</label>
        <select name="grado_academico_id" class="form-select @error('grado_academico_id') is-invalid @enderror" required>
            <option value="">Seleccione grado</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->id }}" @selected(old('grado_academico_id', $estudiante->grado_academico_id ?? '') == $grado->id)>
                    {{ $grado->nombre_grado }}
                </option>
            @endforeach
        </select>
        @error('grado_academico_id') <div class="invalid-feedback">{{ $message }} @enderror
    </div>
</div>



<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Acudiente</label>
        <select name="acudiente_id" class="form-select @error('acudiente_id') is-invalid @enderror" required>
            <option value="">Seleccione acudiente</option>
            @foreach($acudientes as $acudiente)
                <option value="{{ $acudiente->id }}" @selected(old('acudiente_id', $estudiante->acudiente_id ?? '') == $acudiente->id)>
                    {{ $acudiente->user->name ?? 'N/A' }}
                </option>
            @endforeach
        </select>
        @error('acudiente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Año/Curso Lectivo</label>
        <input type="text" name="anho_curso_estudiante" class="form-control @error('anho_curso_estudiante') is-invalid @enderror" 
               value="{{ old('anho_curso_estudiante', $estudiante->anho_curso_estudiante ?? '') }}" required placeholder="Ej: 2026">
        @error('anho_curso_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Email de Contacto</label>
        <input type="email" name="email_estudiante" class="form-control @error('email_estudiante') is-invalid @enderror" 
               value="{{ old('email_estudiante', $estudiante->email_estudiante ?? '') }}" required>
        @error('email_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono_estudiante" class="form-control @error('telefono_estudiante') is-invalid @enderror" 
               value="{{ old('telefono_estudiante', $estudiante->telefono_estudiante ?? '') }}" required>
        @error('telefono_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion_estudiante" class="form-control @error('direccion_estudiante') is-invalid @enderror" 
               value="{{ old('direccion_estudiante', $estudiante->direccion_estudiante ?? '') }}" required>
        @error('direccion_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tipo de Identificación</label>
        <select name="tipo_identificacion_estudiante" class="form-select @error('tipo_identificacion_estudiante') is-invalid @enderror" required>
            <option value="TI" @selected(old('tipo_identificacion_estudiante', $estudiante->tipo_identificacion_estudiante ?? '') == 'TI')>Tarjeta de Identidad</option>
            <option value="RC" @selected(old('tipo_identificacion_estudiante', $estudiante->tipo_identificacion_estudiante ?? '') == 'RC')>Registro Civil</option>
            <option value="CC" @selected(old('tipo_identificacion_estudiante', $estudiante->tipo_identificacion_estudiante ?? '') == 'CC')>Cédula de Ciudadanía</option>
        </select>
        @error('tipo_identificacion_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Número de Identificación</label>
        <input type="text" name="numero_identificacion_estudiante" class="form-control @error('numero_identificacion_estudiante') is-invalid @enderror" 
               value="{{ old('numero_identificacion_estudiante', $estudiante->numero_identificacion_estudiante ?? '') }}" required>
        @error('numero_identificacion_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="estado_estudiante" value="1" 
                   @checked(old('estado_estudiante', $estudiante->estado_estudiante ?? true))>
            <label class="form-check-label">Estudiante Activo</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
    <a href="{{ route('admin.estudiante.index') }}" class="btn btn-warning"><i class="fa fa-times"></i> Cancelar</a>
</div>
