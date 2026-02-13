<div class="mb-3">
        <label class="form-label">Nombre de la Institución</label>
        <input type="text"
               name="nombre_institucion"
               class="form-control"
               value="{{ old('nombre_institucion', $institucion->nombre_institucion ?? '') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion_institucion"
                  class="form-control"
                  rows="3"
                  required>{{ old('descripcion_institucion', $institucion->descripcion_institucion ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Código DANE</label>
        <input type="text"
               name="codigo_dane"
               class="form-control"
               value="{{ old('codigo_dane', $institucion->codigo_dane ?? '') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Ciudad</label>
        <input type="text"
               name="ciudad_institucion"
               class="form-control"
               value="{{ old('ciudad_institucion', $institucion->ciudad_institucion ?? '') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Departamento</label>
        <input type="text"
               name="departamento_institucion"
               class="form-control"
               value="{{ old('departamento_institucion', $institucion->departamento_institucion ?? '') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Rector</label>
        <select name="rector_id" class="form-select" required>
            <option value="">Seleccione</option>
            @foreach($rectores as $rector)
                <option value="{{ $rector->id }}"
                    @selected(old('rector_id', $institucion->rector_id ?? '') == $rector->id)>
                    {{ $rector->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Resolución</label>
        <input type="text"
               name="resolucion_institucion"
               class="form-control"
               value="{{ old('resolucion_institucion', $institucion->resolucion_institucion ?? '') }}">
    </div>


    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Guardar
        </button>

        <a href="{{ route('admin.institucion.index') }}" class="btn btn-warning">
            Cancelar
        </a>
    </div>