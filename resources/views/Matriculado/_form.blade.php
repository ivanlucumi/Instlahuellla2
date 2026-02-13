<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estudiante</label>
        <div class="input-group">
            <select name="estudiante_id" id="estudiante_id" class="form-select select-estudiante @error('estudiante_id') is-invalid @enderror" required>
                <option value="">Seleccione un estudiante</option>
                @foreach($estudiantes as $estudiante)
                    <option value="{{ $estudiante->id }}" @selected(old('estudiante_id', $matriculado->estudiante_id ?? '') == $estudiante->id)>
                        {{ $estudiante->user->name ?? 'Sin nombre' }} ({{ $estudiante->codigo_estudiante }})
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.estudiante.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo estudiante en pestaña nueva">
                <i class="fa fa-plus"></i>
            </a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.estudiante.list') }}" data-select="select-estudiante" title="Actualizar lista">
                <i class="fa fa-sync"></i>
            </button>
        </div>
        @error('estudiante_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Acudiente</label>
        <div class="input-group">
            <select name="acudiente_id" id="acudiente_id" class="form-select select-acudiente @error('acudiente_id') is-invalid @enderror" required>
                <option value="">Seleccione un acudiente</option>
                @foreach($acudientes as $acudiente)
                    <option value="{{ $acudiente->id }}" @selected(old('acudiente_id', $matriculado->acudiente_id ?? '') == $acudiente->id)>
                        {{ $acudiente->user->name ?? 'Sin nombre' }} - {{ $acudiente->parentesco_acudiente }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.acudiente.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo acudiente en pestaña nueva">
                <i class="fa fa-plus"></i>
            </a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.acudiente.list') }}" data-select="select-acudiente" title="Actualizar lista">
                <i class="fa fa-sync"></i>
            </button>
        </div>
        @error('acudiente_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Asignatura</label>
        <div class="input-group">
            <select name="asignatura_id" id="asignatura_id" class="form-select select-asignatura @error('asignatura_id') is-invalid @enderror" required>
                <option value="">Seleccione una asignatura</option>
                @foreach($asignaturas as $asignatura)
                    <option value="{{ $asignatura->id }}" @selected(old('asignatura_id', $matriculado->asignatura_id ?? '') == $asignatura->id)>
                        {{ $asignatura->nombre_asignatura }} ({{ ucfirst($asignatura->nivel_educativo) }})
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.asignatura.create') }}" target="_blank" class="btn btn-success" title="Crear nueva asignatura en pestaña nueva">
                <i class="fa fa-plus"></i>
            </a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.asignatura.list') }}" data-select="select-asignatura" title="Actualizar lista">
                <i class="fa fa-sync"></i>
            </button>
        </div>
        @error('asignatura_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Grado Académico</label>
        <div class="input-group">
            <select name="grado_id" id="grado_id" class="form-select select-grado @error('grado_id') is-invalid @enderror" required>
                <option value="">Seleccione un grado</option>
                @foreach($grados as $grado)
                    <option value="{{ $grado->id }}" @selected(old('grado_id', $matriculado->grado_id ?? '') == $grado->id)>
                        {{ $grado->nombre_grado }} - {{ $grado->bloque }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.gradoacademico.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo grado en pestaña nueva">
                <i class="fa fa-plus"></i>
            </a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.gradoacademico.list') }}" data-select="select-grado" title="Actualizar lista">
                <i class="fa fa-sync"></i>
            </button>
        </div>
        @error('grado_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Año Escolar</label>
        <div class="input-group">
            <select name="anho_escolar_id" id="anho_escolar_id" class="form-select select-anho-escolar @error('anho_escolar_id') is-invalid @enderror" required>
                <option value="">Seleccione un año escolar</option>
                @foreach($anhosEscolares as $anho)
                    <option value="{{ $anho->id }}" @selected(old('anho_escolar_id', $matriculado->anho_escolar_id ?? '') == $anho->id)>
                        {{ $anho->nombre_anho_escolar }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.anhoescolar.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo año en pestaña nueva">
                <i class="fa fa-plus"></i>
            </a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.anhoescolar.list') }}" data-select="select-anho-escolar" title="Actualizar lista">
                <i class="fa fa-sync"></i>
            </button>
        </div>
        @error('anho_escolar_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha de Matrícula</label>
        <input type="date" 
               name="fecha_matricula" 
               class="form-control @error('fecha_matricula') is-invalid @enderror"
               value="{{ old('fecha_matricula', $matriculado->fecha_matricula?->format('Y-m-d') ?? date('Y-m-d')) }}"
               required>
        @error('fecha_matricula')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="activo" @selected(old('estado', $matriculado->estado ?? 'activo') == 'activo')>
                Activo
            </option>
            <option value="inactivo" @selected(old('estado', $matriculado->estado ?? '') == 'inactivo')>
                Inactivo
            </option>
            <option value="retirado" @selected(old('estado', $matriculado->estado ?? '') == 'retirado')>
                Retirado
            </option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" 
                  class="form-control @error('observaciones') is-invalid @enderror"
                  rows="3">{{ old('observaciones', $matriculado->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar Matrícula
    </button>
    <a href="{{ route('admin.matriculado.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.btn-refresh').click(function() {
        const btn = $(this);
        const url = btn.data('url');
        const selectClass = btn.data('select');
        const originalHtml = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                const selects = $('.' + selectClass);
                selects.each(function() {
                    const select = $(this);
                    const currentValue = select.val();
                    const firstOption = select.find('option:first');
                    
                    select.empty().append(firstOption);
                    
                    data.forEach(item => {
                        const option = new Option(item.text, item.id, false, item.id == currentValue);
                        select.append(option);
                    });
                    
                    if (currentValue) select.val(currentValue);
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Lista actualizada',
                    timer: 1000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar',
                    text: 'No se pudo obtener la información actualizada.'
                });
            },
            complete: function() {
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>
