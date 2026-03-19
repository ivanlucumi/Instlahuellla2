<div class="mb-3">
    <label class="form-label">Nombre de la Sede</label>
    <input type="text"
           name="nombre_sede"
           class="form-control @error('nombre_sede') is-invalid @enderror"
           value="{{ old('nombre_sede', $sede->nombre_sede ?? '') }}"
           required>
    @error('nombre_sede')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion_sede"
              class="form-control @error('descripcion_sede') is-invalid @enderror"
              rows="3"
              required>{{ old('descripcion_sede', $sede->descripcion_sede ?? '') }}</textarea>
    @error('descripcion_sede')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Código DANE</label>
        <input type="text"
               name="codigo_dane_sede"
               class="form-control @error('codigo_dane_sede') is-invalid @enderror"
               value="{{ old('codigo_dane_sede', $sede->codigo_dane_sede ?? '') }}"
               required>
        @error('codigo_dane_sede')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Resolución</label>
        <input type="text"
               name="resolucion_sede"
               class="form-control @error('resolucion_sede') is-invalid @enderror"
               value="{{ old('resolucion_sede', $sede->resolucion_sede ?? '') }}"
               required>
        @error('resolucion_sede')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Institución</label>
    <select name="institucion_id" 
            class="form-select @error('institucion_id') is-invalid @enderror" 
            required>
        <option value="">Seleccione una institución</option>
        @foreach($instituciones as $institucion)
            <option value="{{ $institucion->id }}"
                @selected(old('institucion_id', $sede->institucion_id ?? '') == $institucion->id)>
                {{ $institucion->nombre_institucion }}
            </option>
        @endforeach
    </select>
    @error('institucion_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Zona</label>
        <select name="zona_sede" class="form-select">
            <option value="RURAL" @selected(old('zona_sede', $sede->zona_sede ?? 'RURAL') == 'RURAL')>RURAL</option>
            <option value="URBANA" @selected(old('zona_sede', $sede->zona_sede ?? '') == 'URBANA')>URBANA</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Jornada</label>
        <select name="jornada" class="form-select">
            <option value="MAÑANA" @selected(old('jornada', $sede->jornada ?? 'MAÑANA') == 'MAÑANA')>MAÑANA</option>
            <option value="TARDE" @selected(old('jornada', $sede->jornada ?? '') == 'TARDE')>TARDE</option>
            <option value="NOCTURNA" @selected(old('jornada', $sede->jornada ?? '') == 'NOCTURNA')>NOCTURNA</option>
            <option value="UNICA" @selected(old('jornada', $sede->jornada ?? '') == 'UNICA')>UNICA</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <div class="form-check form-switch">
        <input class="form-check-input" 
               type="checkbox" 
               name="estado_sede" 
               id="estado_sede"
               value="1"
               @checked(old('estado_sede', $sede->estado_sede ?? true))>
        <label class="form-check-label" for="estado_sede">
            Sede Activa
        </label>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>

    <a href="{{ route('admin.sede.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
