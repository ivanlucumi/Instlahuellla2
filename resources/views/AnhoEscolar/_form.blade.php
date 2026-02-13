<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Nombre del Año Escolar</label>
        <input type="text" name="nombre_anho_escolar" class="form-control @error('nombre_anho_escolar') is-invalid @enderror" 
               value="{{ old('nombre_anho_escolar', $anhoEscolar->nombre_anho_escolar ?? '') }}" required placeholder="Ej: Año Lectivo 2026">
        @error('nombre_anho_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio_anho_escolar" class="form-control @error('fecha_inicio_anho_escolar') is-invalid @enderror" 
               value="{{ old('fecha_inicio_anho_escolar', isset($anhoEscolar) ? $anhoEscolar->fecha_inicio_anho_escolar->format('Y-m-d') : '') }}" required>
        @error('fecha_inicio_anho_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin_anho_escolar" class="form-control @error('fecha_fin_anho_escolar') is-invalid @enderror" 
               value="{{ old('fecha_fin_anho_escolar', isset($anhoEscolar) ? $anhoEscolar->fecha_fin_anho_escolar->format('Y-m-d') : '') }}" required>
        @error('fecha_fin_anho_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion_anho_escolar" class="form-control @error('descripcion_anho_escolar') is-invalid @enderror" 
                  rows="3" required>{{ old('descripcion_anho_escolar', $anhoEscolar->descripcion_anho_escolar ?? '') }}</textarea>
        @error('descripcion_anho_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="estado_anho_escolar" value="1" 
                   @checked(old('estado_anho_escolar', $anhoEscolar->estado_anho_escolar ?? true))>
            <label class="form-check-label">Año Escolar Activo</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
    <a href="{{ route('admin.anhoescolar.index') }}" class="btn btn-warning"><i class="fa fa-times"></i> Cancelar</a>
</div>
