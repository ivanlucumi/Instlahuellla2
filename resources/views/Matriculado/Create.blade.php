@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Nueva Matrícula</h6>
                <form action="{{ route('admin.matriculado.store') }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary border-bottom pb-2">1. Datos del Estudiante (Asociado a esta matrícula)</h5>
                        </div>

                        <!-- Documento -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="documento_estudiante">Documento del Estudiante (ID)</label>
                            <input type="number" name="documento_estudiante" id="documento_estudiante" class="form-control form-control-lg border-primary @error('documento_estudiante') is-invalid @enderror" value="{{ old('documento_estudiante') }}" required placeholder="Ingrese ID del Estudiante">
                            <small class="text-muted">Si el estudiante no existe, se creará automáticamente con la siguiente información.</small>
                            @error('documento_estudiante') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div id="estudiante_fields_container" class="row w-100 m-0">
                            <!-- Name & Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo del Estudiante</label>
                                <input type="text" name="name" id="estudiante_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico (Opcional)</label>
                                <input type="email" name="email" id="estudiante_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tipo Identificación</label>
                                <select name="tipo_identificacion_estudiante" id="estudiante_tipo_id" class="form-select">
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="CC" selected>Cédula de Ciudadanía</option>
                                    <option value="RC">Registro Civil</option>
                                    <option value="CE">Cédula de Extranjería</option>
                                    <option value="PEP">PEP</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Celular Estudiante</label>
                                <input type="text" name="celular_estudiante" id="estudiante_celular" class="form-control" value="{{ old('celular_estudiante') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Dirección Estudiante</label>
                                <input type="text" name="direccion_estudiante" id="estudiante_direccion" class="form-control" value="{{ old('direccion_estudiante') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Género</label>
                                <select name="genero_estudiante" id="estudiante_genero" class="form-select">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento_estudiante" id="estudiante_fecha_nacimiento" class="form-control @error('fecha_nacimiento_estudiante') is-invalid @enderror" value="{{ old('fecha_nacimiento_estudiante') }}" required>
                            @error('fecha_nacimiento_estudiante') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary border-bottom pb-2 mt-2">2. Configuración de Matrícula</h5>
                        </div>

                        <!-- Sede Implícita -->
                        <input type="hidden" name="id_sede" id="id_sede" value="{{ old('id_sede') }}">

                        <!-- Grado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Grado Académico y Curso</label>
                            <div class="input-group">
                                <select name="id_grado" id="id_grado" class="form-select select-grado @error('id_grado') is-invalid @enderror" required>
                                    <option value="">Seleccione grado</option>
                                    @foreach($grados as $grado)
                                        <option value="{{ $grado->id }}" data-bloque="{{ $grado->bloque }}" data-sede="{{ $grado->sede_id }}" data-docente-user-id="{{ $grado->docente?->id }}" data-docente-name="{{ $grado->docente?->user?->name }}" @selected(old('id_grado') == $grado->id)>
                                            {{ $grado->nombre_grado }} - {{ $grado->bloque }} ({{ $grado->sede->nombre_sede ?? 'Sin Sede' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_grado') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Curso/Bloque -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Curso o Subgrupo</label>
                            <input type="text" name="curso" id="curso" class="form-control @error('curso') is-invalid @enderror" 
                                value="{{ old('curso', 'A') }}" required placeholder="1, 2, A, B...">
                            @error('curso') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Acudiente -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="documento_acudiente">Documento Acudiente <span class="badge bg-info ms-1" id="badge_acudiente_status">Buscar</span></label>
                            <div class="input-group">
                                <input type="number" name="documento_acudiente" id="documento_acudiente" class="form-control @error('documento_acudiente') is-invalid @enderror" value="{{ old('documento_acudiente') }}" required placeholder="Ingrese ID Acudiente...">
                                <button type="button" class="btn btn-info" id="btn_buscar_acudiente" title="Buscar Acudiente"><i class="fa fa-search"></i></button>
                            </div>
                            @error('documento_acudiente') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre del Acudiente</label>
                            <input type="text" name="nombre_acudiente" id="nombre_acudiente" class="form-control" value="{{ old('nombre_acudiente') }}" placeholder="Se autocompletará o lo crea..." readonly required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Celular / Teléfono</label>
                            <input type="text" name="celular_acudiente" id="celular_acudiente" class="form-control" value="{{ old('celular_acudiente') }}" placeholder="Número celular..." readonly required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Parentesco</label>
                            <input type="text" name="parentezco_acudiente" id="parentezco_acudiente" class="form-control" value="{{ old('parentezco_acudiente', 'Acudiente') }}" required>
                        </div>

                        <!-- Año Escolar -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Año Lectivo</label>
                            <div class="input-group">
                                <select name="ano_lectivo" id="ano_lectivo" class="form-select select-ano @error('ano_lectivo') is-invalid @enderror" required>
                                    <option value="">Seleccione año...</option>
                                    @foreach($anhosEscolares as $anho)
                                        <option value="{{ $anho->nombre_anho_escolar }}" @selected(old('ano_lectivo') == $anho->nombre_anho_escolar)>
                                            {{ $anho->nombre_anho_escolar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ano_lectivo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Director de Grado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Director de Grado</label>
                            <input type="text" id="nombre_director" class="form-control" readonly placeholder="Asignado automáticamente por grado">
                            <input type="hidden" name="id_profesor" id="id_profesor" value="{{ old('id_profesor') }}">
                            @error('id_profesor') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha Matrícula</label>
                            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
                            @error('fecha') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="retirado">Retirado</option>
                            </select>
                            @error('estado') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top border-secondary pt-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save me-1"></i> Confirmar y Matricular
                        </button>
                        <a href="{{ route('admin.matriculado.index') }}" class="btn btn-outline-warning btn-lg">
                            <i class="fa fa-arrow-left me-1"></i> Cancelar
                        </a>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        $(document).ready(function() {
                            $('#id_grado').on('change', function() {
                                let el = $(this);
                                let option = el.find('option:selected');
                                
                                if(option.val() !== "") {
                                    let bloque = option.data('bloque');
                                    let sedeId = option.data('sede');
                                    let docenteUserId = option.data('docente-user-id');
                                    let docenteName = option.data('docente-name');
                                    
                                    if (bloque) {
                                        $('#curso').val(bloque);
                                    }
                                    if (sedeId) {
                                        $('#id_sede').val(sedeId).trigger('change');
                                    }
                                    if (docenteUserId) {
                                        $('#id_profesor').val(docenteUserId);
                                        $('#nombre_director').val(docenteName || 'Director asignado');
                                    } else {
                                        $('#id_profesor').val('');
                                        $('#nombre_director').val('Grado sin director asignado');
                                    }
                                } else {
                                    $('#id_sede').val('').trigger('change');
                                    $('#id_profesor').val('');
                                    $('#nombre_director').val('');
                                }
                            });

                            // Buscar Estudiante
                            $('#documento_estudiante').on('change blur', function() {
                                let doc = $(this).val();
                                if (!doc) return;

                                let icon = $('<i class="fa fa-spinner fa-spin ms-2 text-primary" id="spinner-estudiante"></i>');
                                $('#documento_estudiante').next('small').append(icon);

                                $.ajax({
                                    url: "{{ route('admin.matriculado.datos-estudiante') }}",
                                    type: 'GET',
                                    data: { documento: doc },
                                    success: function(response) {
                                        $('#spinner-estudiante').remove();
                                        if(response.encontrado) {
                                            Swal.fire({icon: 'success', title: 'Estudiante Encontrado', text: 'Datos pre-cargados automáticamente.', timer: 1500, showConfirmButton: false, toast: true, position: 'top-end'});
                                            
                                            // Llenar datos de estudiante
                                            $('#estudiante_name').val(response.name);
                                            $('#estudiante_email').val(response.email);
                                            $('#estudiante_tipo_id').val(response.tipo_id);
                                            $('#estudiante_celular').val(response.celular_estudiante);
                                            $('#estudiante_direccion').val(response.direccion_estudiante);
                                            $('#estudiante_genero').val(response.genero_estudiante);
                                            $('#estudiante_fecha_nacimiento').val(response.fecha_nacimiento);

                                            // Llenar datos de la última matrícula si existen
                                            if (response.ultima_matricula) {
                                                $('#id_grado').val(response.ultima_matricula.id_grado).trigger('change');
                                                $('#curso').val(response.ultima_matricula.curso);
                                                $('#ano_lectivo').val(response.ultima_matricula.ano_lectivo);
                                                // El estado siempre lo dejamos en activo por defecto para nueva matrícula o renovación
                                            }
                                        }
                                    },
                                    error: function() {
                                        $('#spinner-estudiante').remove();
                                    }
                                });
                            });

                            // Buscar Acudiente
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
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
