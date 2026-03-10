<div class="row">
    <!-- Estudiante -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Estudiante</label>
        <div class="input-group">
            <select name="documento_estudiante" id="documento_estudiante" class="form-select select-estudiante @error('documento_estudiante') is-invalid @enderror" required>
                <option value="">Seleccione un estudiante</option>
                @foreach($estudiantes as $estudiante)
                    <option value="{{ $estudiante->numero_identificacion_estudiante }}" @selected(old('documento_estudiante', $matriculado->documento_estudiante ?? '') == $estudiante->numero_identificacion_estudiante)>
                        {{ $estudiante->user->name ?? 'Sin nombre' }} ({{ $estudiante->numero_identificacion_estudiante }})
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.estudiante.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo estudiante en pestaña nueva"><i class="fa fa-plus"></i></a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.estudiante.list') }}" data-select="select-estudiante" title="Actualizar lista"><i class="fa fa-sync"></i></button>
        </div>
        @error('documento_estudiante') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <!-- Acudiente -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Acudiente y Parentesco</label>
        <div class="input-group">
            <select name="documento_acudiente" id="documento_acudiente" class="form-select select-acudiente @error('documento_acudiente') is-invalid @enderror" required onchange="updateParentesco(this)">
                <option value="">Seleccione un acudiente</option>
                @foreach($acudientes as $acudiente)
                    <option value="{{ $acudiente->id_documento }}" data-parentesco="{{ $acudiente->parentesco_acudiente }}" @selected(old('documento_acudiente', $matriculado->documento_acudiente ?? '') == $acudiente->id_documento)>
                        {{ $acudiente->user->name ?? 'Sin nombre' }} ({{ $acudiente->id_documento }})
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.acudiente.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo acudiente en pestaña nueva"><i class="fa fa-plus"></i></a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.acudiente.list') }}" data-select="select-acudiente" title="Actualizar lista"><i class="fa fa-sync"></i></button>
        </div>
        <input type="hidden" name="parentezco_acudiente" id="parentezco_acudiente" value="{{ old('parentezco_acudiente', $matriculado->parentezco_acudiente ?? '') }}">
        @error('documento_acudiente') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <!-- Sede -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Sede / Institución</label>
        <select name="id_sede" id="id_sede" class="form-select @error('id_sede') is-invalid @enderror" required>
            <option value="">Seleccione una sede</option>
            @foreach($sedes as $sede)
                <option value="{{ $sede->id }}" @selected(old('id_sede', $matriculado->id_sede ?? '') == $sede->id)>
                    {{ $sede->nombre_sede }}
                </option>
            @endforeach
        </select>
        @error('id_sede') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <!-- Director de Grado -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Director de Curso (Opcional)</label>
        <select name="id_profesor" id="id_profesor" class="form-select @error('id_profesor') is-invalid @enderror">
            <option value="">Seleccione director...</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}" @selected(old('id_profesor', $matriculado->id_profesor ?? '') == $docente->id)>
                    {{ $docente->name }}
                </option>
            @endforeach
        </select>
        @error('id_profesor') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <!-- Grado -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Grado Académico</label>
        <div class="input-group">
            <select name="id_grado" id="id_grado" class="form-select select-grado @error('id_grado') is-invalid @enderror" required onchange="matchCurso()">
                <option value="">Seleccione grado</option>
                @foreach($grados as $grado)
                    <option value="{{ $grado->id }}" data-bloque="{{ $grado->bloque }}" @selected(old('id_grado', $matriculado->id_grado ?? '') == $grado->id)>
                        {{ $grado->nombre_grado }} - {{ $grado->bloque }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.gradoacademico.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo grado"><i class="fa fa-plus"></i></a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.gradoacademico.list') }}" data-select="select-grado" title="Actualizar lista"><i class="fa fa-sync"></i></button>
        </div>
        @error('id_grado') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <!-- Curso/Bloque -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Curso o Subgrupo</label>
        <input type="text" name="curso" id="curso" class="form-control @error('curso') is-invalid @enderror" 
            value="{{ old('curso', $matriculado->curso ?? '1') }}" required placeholder="1, 2, A, B...">
        <small class="text-muted">Generalmente corresponde al Bloque del Grado</small>
        @error('curso') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <!-- Año Escolar -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Año Lectivo</label>
        <div class="input-group">
            <select name="ano_lectivo" id="ano_lectivo" class="form-select select-ano @error('ano_lectivo') is-invalid @enderror" required>
                <option value="">Seleccione año...</option>
                @foreach($anhosEscolares as $anho)
                    <option value="{{ $anho->nombre_anho_escolar }}" @selected(old('ano_lectivo', $matriculado->ano_lectivo ?? '') == $anho->nombre_anho_escolar)>
                        {{ $anho->nombre_anho_escolar }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.anhoescolar.create') }}" target="_blank" class="btn btn-success" title="Crear nuevo año"><i class="fa fa-plus"></i></a>
            <button type="button" class="btn btn-info btn-refresh" data-url="{{ route('admin.anhoescolar.list') }}" data-select="select-ano" title="Actualizar lista"><i class="fa fa-sync"></i></button>
        </div>
        @error('ano_lectivo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <!-- Fecha -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha de Matrícula</label>
        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $matriculado->fecha ? date('Y-m-d', strtotime($matriculado->fecha)) : date('Y-m-d')) }}" required>
        @error('fecha') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <!-- Estado -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado de la Matrícula</label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="activo" @selected(old('estado', $matriculado->estado ?? 'activo') == 'activo')>Activo</option>
            <option value="inactivo" @selected(old('estado', $matriculado->estado ?? '') == 'inactivo')>Inactivo</option>
            <option value="retirado" @selected(old('estado', $matriculado->estado ?? '') == 'retirado')>Retirado</option>
        </select>
        @error('estado') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mt-4 border-top border-secondary pt-3">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save me-1"></i> Guardar Matrícula
    </button>
    <a href="{{ route('admin.matriculado.index') }}" class="btn btn-outline-warning">
        <i class="fa fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateParentesco(element) {
        let parentesco = element.options[element.selectedIndex].getAttribute('data-parentesco');
        document.getElementById('parentezco_acudiente').value = parentesco || 'Acudiente';
    }

    function matchCurso() {
        let el = document.getElementById('id_grado');
        if(el.selectedIndex > 0) {
            let bloque = el.options[el.selectedIndex].getAttribute('data-bloque');
            if (bloque) {
                document.getElementById('curso').value = bloque;
            }
        }
    }

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
                            // Note: We might need to ensure the ID/Value returned by API matches what we need
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
