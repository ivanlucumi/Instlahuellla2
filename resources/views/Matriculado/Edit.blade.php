@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Editar Matrícula</h6>
                <form action="{{ route('admin.matriculado.update', $matriculado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary border-bottom pb-2">Datos del Estudiante (Asociado a esta matrícula)</h5>
                        </div>
                        
                        <!-- Name & Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo del Estudiante</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $matriculado->estudiante->user->name ?? '') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $matriculado->estudiante->user->email ?? '') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Documento (Read-only as it links everything) -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" name="documento_estudiante" class="form-control" value="{{ $matriculado->documento_estudiante }}" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Celular Estudiante</label>
                            <input type="text" name="celular_estudiante" class="form-control @error('celular_estudiante') is-invalid @enderror" value="{{ old('celular_estudiante', $matriculado->estudiante->celular_estudiante ?? '') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Dirección Estudiante</label>
                            <input type="text" name="direccion_estudiante" class="form-control @error('direccion_estudiante') is-invalid @enderror" value="{{ old('direccion_estudiante', $matriculado->estudiante->direccion_estudiante ?? '') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_nacimiento_estudiante" class="form-control @error('fecha_nacimiento_estudiante') is-invalid @enderror"
                                value="{{ old('fecha_nacimiento_estudiante', $matriculado->estudiante->fecha_nacimiento_estudiante ? $matriculado->estudiante->fecha_nacimiento_estudiante->format('Y-m-d') : '') }}" required>
                            @error('fecha_nacimiento_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Género</label>
                            <select name="genero_estudiante" class="form-select">
                                <option value="Masculino" @selected(old('genero_estudiante', $matriculado->estudiante->genero_estudiante ?? '') == 'Masculino')>Masculino</option>
                                <option value="Femenino" @selected(old('genero_estudiante', $matriculado->estudiante->genero_estudiante ?? '') == 'Femenino')>Femenino</option>
                                <option value="Otro" @selected(old('genero_estudiante', $matriculado->estudiante->genero_estudiante ?? '') == 'Otro')>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary border-bottom pb-2 mt-2">Configuración de Matrícula</h5>
                        </div>

                        <!-- Acudiente -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="documento_acudiente">Documento Acudiente <span class="badge bg-info ms-1" id="badge_acudiente_status">Buscar</span></label>
                            <div class="input-group">
                                <input type="number" name="documento_acudiente" id="documento_acudiente" class="form-control @error('documento_acudiente') is-invalid @enderror" value="{{ old('documento_acudiente', $matriculado->documento_acudiente ?? '') }}" required placeholder="Ingrese ID Acudiente...">
                                <button type="button" class="btn btn-info" id="btn_buscar_acudiente" title="Buscar Acudiente"><i class="fa fa-search"></i></button>
                            </div>
                            @error('documento_acudiente') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre del Acudiente</label>
                            <input type="text" name="nombre_acudiente" id="nombre_acudiente" class="form-control" value="{{ old('nombre_acudiente', $matriculado->acudiente->user->name ?? '') }}" placeholder="Se autocompletará o lo crea..." readonly required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Celular / Teléfono</label>
                            <input type="text" name="celular_acudiente" id="celular_acudiente" class="form-control" value="{{ old('celular_acudiente', $matriculado->acudiente->celular_acudiente ?? '') }}" placeholder="Número celular..." readonly required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="parentezco_acudiente" id="parentezco_acudiente" value="{{ old('parentezco_acudiente', $matriculado->parentezco_acudiente ?? 'Acudiente') }}">
                        </div>

                        <!-- Sede Implícita -->
                        <input type="hidden" name="id_sede" id="id_sede" value="{{ old('id_sede', $matriculado->id_sede ?? '') }}">

                        <!-- Grado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Grado Académico</label>
                            <div class="input-group">
                                <select name="id_grado" id="id_grado" class="form-select select-grado @error('id_grado') is-invalid @enderror" required>
                                    <option value="">Seleccione grado</option>
                                    @foreach($grados as $grado)
                                        <option value="{{ $grado->id }}" data-bloque="{{ $grado->bloque }}" data-sede="{{ $grado->sede_id }}" data-docente-user-id="{{ $grado->docente?->user_id }}" @selected(old('id_grado', $matriculado->id_grado ?? '') == $grado->id)>
                                            {{ $grado->nombre_grado }} - {{ $grado->bloque }} ({{ $grado->sede->nombre_sede ?? 'Sin Sede' }})
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

                        <!-- Director de Grado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Director (Opcional)</label>
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

                        <!-- Fecha -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha Matrícula</label>
                            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $matriculado->fecha ? date('Y-m-d', strtotime($matriculado->fecha)) : date('Y-m-d')) }}" required>
                            @error('fecha') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado</label>
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
                            <i class="fa fa-save me-1"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('admin.matriculado.index') }}" class="btn btn-outline-warning">
                            <i class="fa fa-arrow-left me-1"></i> Cancelar
                        </a>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        function updateParentesco(element) {
                            let parentesco = element.options[element.selectedIndex].getAttribute('data-parentesco');
                            document.getElementById('parentezco_acudiente').value = parentesco || 'Acudiente';
                        }

                        $(document).ready(function() {
                            $('#id_grado').on('change', function() {
                                let el = $(this);
                                let option = el.find('option:selected');
                                
                                if(option.val() !== "") {
                                    let bloque = option.data('bloque');
                                    let sedeId = option.data('sede');
                                    let docenteUserId = option.data('docente-user-id');
                                    
                                    if (bloque) {
                                        $('#curso').val(bloque);
                                    }
                                    if (sedeId) {
                                        $('#id_sede').val(sedeId).trigger('change');
                                    }
                                    if (docenteUserId) {
                                        $('#id_profesor').val(docenteUserId).trigger('change');
                                    } else {
                                        $('#id_profesor').val('').trigger('change');
                                    }
                                } else {
                                    $('#id_sede').val('').trigger('change');
                                    $('#id_profesor').val('').trigger('change');
                                }
                            });

                            $('#btn_buscar_acudiente').click(function() {
                                let cc = $('#documento_acudiente').val();
                                let btn = $(this);
                                let badge = $('#badge_acudiente_status');
                                
                                if(!cc) {
                                    Swal.fire({icon: 'warning', title: 'Atención', text: 'Ingrese un documento primero.'});
                                    return;
                                }

                                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                                badge.text('Buscando...').removeClass('bg-info bg-success bg-warning').addClass('bg-secondary');

                                $.ajax({
                                    url: "{{ route('admin.acudiente.buscar') }}",
                                    type: 'GET',
                                    data: { documento: cc },
                                    success: function(response) {
                                        if(response.encontrado) {
                                            $('#nombre_acudiente').val(response.nombre).prop('readonly', true);
                                            $('#celular_acudiente').val(response.celular).prop('readonly', true);
                                            $('#parentezco_acudiente').val(response.parentesco);
                                            badge.text('Encontrado').removeClass('bg-secondary bg-warning').addClass('bg-success');
                                            Swal.fire({icon: 'success', title: 'Acudiente Encontrado', timer: 1000, showConfirmButton: false, toast: true, position: 'top-end'});
                                        } else {
                                            $('#nombre_acudiente').val('').prop('readonly', false).focus();
                                            $('#celular_acudiente').val('').prop('readonly', false);
                                            $('#parentezco_acudiente').val('Acudiente');
                                            badge.text('Nuevo - Llene datos').removeClass('bg-secondary bg-success').addClass('bg-warning text-dark');
                                            Swal.fire({icon: 'info', title: 'Acudiente No Registrado', text: 'Por favor ingrese el nombre y celular. Se creará automáticamente al guardar.', confirmButtonText: 'Entendido'});
                                        }
                                    },
                                    error: function() {
                                        Swal.fire({icon: 'error', title: 'Error', text: 'No se pudo consultar la base de datos.'});
                                    },
                                    complete: function() {
                                        btn.prop('disabled', false).html('<i class="fa fa-search"></i>');
                                    }
                                });
                            });

                            // Optionally auto-search when losing focus if changed
                            $('#documento_acudiente').change(function() {
                                $('#btn_buscar_acudiente').click();
                            });

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

                                        Swal.fire({icon: 'success', title: 'Actualizada', timer: 1000, showConfirmButton: false, toast: true, position: 'top-end'});
                                    },
                                    error: function() {
                                        Swal.fire({icon: 'error', title: 'Error', text: 'Error al actualizar.'});
                                    },
                                    complete: function() {
                                        btn.prop('disabled', false).html(originalHtml);
                                    }
                                });
                            });
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
