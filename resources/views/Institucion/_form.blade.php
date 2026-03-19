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

    <div class="row g-3">
        <div class="col-md-6 mb-3">
            <label class="form-label">Jerarquía</label>
            <select name="jerarquia" class="form-select">
                <option value="CALOTO" @selected(old('jerarquia', $institucion->jerarquia ?? 'CALOTO') == 'CALOTO')>CALOTO</option>
                <option value="OTRA" @selected(old('jerarquia', $institucion->jerarquia ?? '') == 'OTRA')>OTRA</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Calendario</label>
            <select name="calendario" class="form-select">
                <option value="A" @selected(old('calendario', $institucion->calendario ?? 'A') == 'A')>A</option>
                <option value="B" @selected(old('calendario', $institucion->calendario ?? '') == 'B')>B</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Sector</label>
            <select name="sector" class="form-select">
                <option value="OFICIAL" @selected(old('sector', $institucion->sector ?? 'OFICIAL') == 'OFICIAL')>OFICIAL</option>
                <option value="NO OFICIAL" @selected(old('sector', $institucion->sector ?? '') == 'NO OFICIAL')>NO OFICIAL</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Modelo</label>
            <select name="modelo" class="form-select">
                <option value="ETNOEDUCACIÓN" @selected(old('modelo', $institucion->modelo ?? 'ETNOEDUCACIÓN') == 'ETNOEDUCACIÓN')>ETNOEDUCACIÓN</option>
                <option value="TRADICIONAL" @selected(old('modelo', $institucion->modelo ?? '') == 'TRADICIONAL')>TRADICIONAL</option>
                <option value="FLEXIBLE" @selected(old('modelo', $institucion->modelo ?? '') == 'FLEXIBLE')>FLEXIBLE</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Jornada</label>
            <select name="jornada" class="form-select">
                <option value="MAÑANA" @selected(old('jornada', $institucion->jornada ?? 'MAÑANA') == 'MAÑANA')>MAÑANA</option>
                <option value="TARDE" @selected(old('jornada', $institucion->jornada ?? '') == 'TARDE')>TARDE</option>
                <option value="NOCTURNA" @selected(old('jornada', $institucion->jornada ?? '') == 'NOCTURNA')>NOCTURNA</option>
                <option value="UNICA" @selected(old('jornada', $institucion->jornada ?? '') == 'UNICA')>UNICA</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Resolución</label>
            <input type="text"
                   name="resolucion_institucion"
                   class="form-control"
                   value="{{ old('resolucion_institucion', $institucion->resolucion_institucion ?? '') }}">
        </div>
    </div>


    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Guardar
        </button>

        <a href="{{ route('admin.institucion.index') }}" class="btn btn-warning">
            Cancelar
        </a>
    </div>