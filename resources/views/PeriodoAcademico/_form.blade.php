<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Año Escolar</label>
        <select name="año_escolar_id" class="form-select @error('año_escolar_id') is-invalid @enderror" required>
            <option value="">Seleccione un año escolar</option>
            @foreach($anhos as $anho)
                <option value="{{ $anho->id }}" @selected(old('año_escolar_id', $periodoAcademico->año_escolar_id ?? '') == $anho->id)>
                    {{ $anho->nombre_anho_escolar }}
                </option>
            @endforeach
        </select>
        @error('año_escolar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre del Periodo</label>
        <input type="text" name="nombre_periodo" class="form-control @error('nombre_periodo') is-invalid @enderror" 
               value="{{ old('nombre_periodo', $periodoAcademico->nombre_periodo ?? '') }}" required placeholder="Ej: Primer Periodo">
        @error('nombre_periodo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" 
               value="{{ old('fecha_inicio', isset($periodoAcademico) ? $periodoAcademico->fecha_inicio->format('Y-m-d') : '') }}" required>
        @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" 
               value="{{ old('fecha_fin', isset($periodoAcademico) ? $periodoAcademico->fecha_fin->format('Y-m-d') : '') }}" required>
        @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Peso / Porcentaje (%)</label>
        <input type="number" name="porcentaje_periodo" class="form-control @error('porcentaje_periodo') is-invalid @enderror" 
               value="{{ old('porcentaje_periodo', $periodoAcademico->porcentaje_periodo ?? '') }}" required min="0" max="100" step="0.01">
        @error('porcentaje_periodo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="activo" @selected(old('estado', $periodoAcademico->estado ?? 'activo') == 'activo')>Activo</option>
            <option value="inactivo" @selected(old('estado', $periodoAcademico->estado ?? '') == 'inactivo')>Inactivo</option>
        </select>
        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
    <a href="{{ route('admin.periodoacademico.index') }}" class="btn btn-warning"><i class="fa fa-times"></i> Cancelar</a>
</div>
