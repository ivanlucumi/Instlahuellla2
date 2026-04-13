@extends('layouts.Administracion')

@section('title', 'Gestión de Grado: ' . $gradoAcademico->nombre_grado)

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- Header Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="text-white mb-1">
                            <i class="fa fa-layer-group me-2 text-primary"></i>
                            Grado: {{ $gradoAcademico->nombre_grado }} - "{{ $gradoAcademico->bloque }}"
                        </h3>
                        <p class="text-muted mb-0">
                            <strong>Sede:</strong> {{ $gradoAcademico->sede->nombre_sede ?? 'N/A' }} | 
                            <strong>Curso:</strong> {{ $gradoAcademico->curso->nombre_curso ?? 'N/A' }} |
                            <strong>Director:</strong> {{ $gradoAcademico->docente->user->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0 gap-2 flex-wrap">
                        <form id="globalParams" action="{{ route('admin.gradoacademico.show', $gradoAcademico->id) }}" method="GET" class="d-flex align-items-center gap-2">
                            <label class="text-white small text-nowrap">Ciclo:</label>
                            <select name="anho_escolar_id" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="this.form.submit()" style="width: 100px;">
                                @foreach($anhos as $anho)
                                    <option value="{{ $anho->id }}" @selected($currentAnhoObj->id == $anho->id)>
                                        {{ $anho->nombre_anho_escolar }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <label class="text-white small text-nowrap ms-1">Periodo:</label>
                            @php $selectedPeriodId = request('periodo_id') ?? $periodos->where('estado', 1)->first()?->id ?? ($periodos->first()?->id ?? 1); @endphp
                            <select name="periodo_id" id="sel_periodo_id" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="this.form.submit()" style="width: 100px;">
                                @foreach($periodos as $p)
                                    <option value="{{ $p->id }}" @selected($selectedPeriodId == $p->id)>{{ $p->nombre_periodo }}</option>
                                @endforeach
                            </select>
                        </form>
                        <a href="{{ route('admin.gradoacademico.index') }}" class="btn btn-sm btn-outline-warning">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="bg-secondary rounded p-3 text-center shadow-sm">
                <i class="fa fa-user-graduate fa-2x text-primary mb-2"></i>
                <h5 class="text-white mb-0">{{ $estudiantes->count() }}</h5>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Estudiantes Enrolados</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-3 text-center shadow-sm">
                <i class="fa fa-book fa-2x text-info mb-2"></i>
                <h5 class="text-white mb-0">{{ $gradoAcademico->asignaturas->count() }}</h5>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Materias Asignadas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-3 text-center shadow-sm">
                <i class="fa fa-th-large fa-2x text-warning mb-2"></i>
                <h5 class="text-white mb-0">{{ $cursosDisponibles->count() }}</h5>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Cursos Disponibles ({{ $gradoAcademico->nombre_grado }})</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-3 text-center shadow-sm">
                <i class="fa fa-calendar-check fa-2x text-success mb-2"></i>
                <h5 class="text-white mb-0">{{ $currentAnhoObj->nombre_anho_escolar }}</h5>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Ciclo Escolar Activo</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @if($cursosDisponibles->count() > 1)
        <!-- Dashboard Content: Sidebar with Courses -->
        <div class="col-lg-12 mb-2">
            <div class="bg-secondary rounded p-3">
                <h6 class="text-white mb-3">Cambiar a otro curso del Grado {{ $gradoAcademico->nombre_grado }}:</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($cursosDisponibles as $otroGrado)
                        <a href="{{ route('admin.gradoacademico.show', $otroGrado->id) }}" 
                           class="btn btn-sm {{ $otroGrado->id == $gradoAcademico->id ? 'btn-primary' : 'btn-outline-light' }}">
                           Bloque: {{ $otroGrado->bloque }} ({{ $otroGrado->curso->nombre_curso ?? 'General' }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Left Column: Students -->
        <div class="col-sm-12 col-xl-7">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">
                        <i class="fa fa-users me-2 text-primary"></i> Estudiantes en {{ $currentAnhoObj->nombre_anho_escolar }}
                    </h5>
                    <div class="d-flex gap-1 flex-wrap">
                        @if($isGradoCero)
                            <a href="{{ route('admin.grado-cero.calificaciones.matrix', ['grado_id' => $gradoAcademico->id, 'periodo_id' => $selectedPeriodId, 'anho_escolar_id' => $currentAnhoObj->id]) }}" 
                               class="btn btn-sm btn-info fw-bold">
                                <i class="fa fa-table me-1"></i> Planilla Grado Cero
                            </a>
                            <a href="{{ route('admin.grado-cero.boletin.grupo', [$gradoAcademico->id, $selectedPeriodId, $currentAnhoObj->id]) }}" 
                               class="btn btn-sm btn-outline-success" target="_blank">
                                <i class="fa fa-file-pdf me-1"></i> Boletín Grupal
                            </a>
                        @else
                            <a href="{{ route('admin.certificados.generar-grupo', [
                                'grado_id' => $gradoAcademico->id, 
                                'ano_lectivo' => $currentAnhoObj->nombre_anho_escolar,
                                'curso' => ($gradoAcademico->curso->nombre_curso ?? $gradoAcademico->bloque),
                                'periodo_id' => $selectedPeriodId
                            ]) }}" 
                               class="btn btn-sm btn-outline-info">
                                <i class="fa fa-file-pdf me-1"></i> Certificado Grupal
                            </a>
                        @endif
                        <!--button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalMatricular">
                            <i class="fa fa-user-plus me-1"></i> Matricular
                        </button-->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-white align-middle">
                        <thead class="bg-dark text-info">
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estudiantes as $est)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $est->user->name }}</div>
                                        <small class="text-muted">{{ $est->codigo_estudiante }}</small>
                                    </td>
                                    <td>{{ $est->numero_identificacion_estudiante }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $est->estado_estudiante ? 'bg-success' : 'bg-danger' }} rounded-pill" style="font-size: 0.7rem;">
                                            {{ $est->estado_estudiante ? 'ACTIVO' : 'INACTIVO' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-dark">
                                                <li><a class="dropdown-item" href="{{ route('admin.estudiante.edit', $est->id) }}"><i class="fa fa-edit me-2"></i>Ver Perfil</a></li>
                                                <li>
                                                    @php
                                                        // $matriculadosMF ya viene filtrado por Grado, Año y Curso desde el controlador
                                                        $mfRec = $matriculadosMF->firstWhere('documento_estudiante', $est->numero_identificacion_estudiante);
                                                    @endphp
                                                    
                                                    @if($mfRec)
                                                        @if($isGradoCero)
                                                            <a class="dropdown-item text-success" target="_blank"
                                                               href="{{ route('admin.grado-cero.boletin.descargar', [$est->id, $selectedPeriodId, $currentAnhoObj->id]) }}">
                                                                <i class="fa fa-file-pdf me-2"></i>Descargar Boletín Cero
                                                            </a>
                                                        @else
                                                            <a class="dropdown-item text-info cert-link" target="_blank"
                                                               href="{{ route('admin.certificados.por-matricula', ['id' => $mfRec->id, 'periodo_id' => $selectedPeriodId]) }}">
                                                                <i class="fa fa-file-pdf me-2"></i>Generar Certificado
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="dropdown-item text-muted"><i class="fa fa-file-pdf me-2"></i>Sin matrícula</span>
                                                    @endif
                                                </li>
                                                @if(auth()->user()->hasRol('SUPERADMIN'))
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fa fa-trash me-2"></i>Retirar</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted italic">
                                        <i class="fa fa-info-circle me-1"></i> No se han encontrado estudiantes matriculados en este ciclo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Subjects -->
        <div class="col-sm-12 col-xl-5">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">
                        <i class="fa fa-book-open me-2 text-primary"></i>
                        @if($esAnhoActual)
                            Asignaturas del Año Actual
                        @else
                            Asignaturas Históricas ({{ $currentAnhoObj->nombre_anho_escolar }})
                        @endif
                    </h5>
                    @if($esAnhoActual)
                    <a href="{{ route('admin.gradoacademico.edit', $gradoAcademico->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-cog me-1"></i> Gestionar
                    </a>
                    @endif
                </div>

                @if(!$esAnhoActual)
                <div class="alert alert-info bg-dark border-info text-white small mb-3">
                    <i class="fa fa-history me-1"></i> Visualizando asignaturas con notas registradas en el año <strong>{{ $currentAnhoObj->nombre_anho_escolar }}</strong>. Para gestionar el plan de estudios actual usa el año en curso.
                </div>
                @endif
                
                <div class="list-group list-group-flush list-group-dark">
                    @php
                        $user_id = auth()->id();
                        $misAsignaturas = $gradoAcademico->asignaturas->filter(fn($as) => $as->pivot->docente_id == $user_id);
                        $otrasAsignaturas = $gradoAcademico->asignaturas->filter(fn($as) => $as->pivot->docente_id != $user_id);
                        $isAdmin = auth()->user()->hasAnyRol(['SUPERADMIN', 'RECTOR', 'ADMIN']);
                    @endphp

                    {{-- 1. Mis Asignaturas --}}
                    @if($misAsignaturas->isNotEmpty())
                        <h6 class="text-primary mt-2 mb-3 px-2 border-start border-2 border-primary py-1" style="background: rgba(13, 110, 253, 0.05);">
                            <i class="fa fa-user-check me-2"></i>MIS ASIGNATURAS
                            <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: normal;">Materias que imparto en este grado y puedo calificar.</small>
                        </h6>
                        @foreach($misAsignaturas as $asig)
                            <div class="list-group-item bg-transparent text-white border-secondary py-3 px-2 mb-2 rounded border">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-info">{{ $asig->nombre_asignatura }}</h6>
                                        <small class="d-block text-white-50">
                                            <i class="fa fa-layer-group me-1"></i> {{ $asig->hilo->nombre_hilo ?? 'Sin núcleo' }}
                                        </small>
                                    </div>
                                    @if($esAnhoActual)
                                    <a href="{{ route('docente.asignatura.estudiantes', ['asignatura' => $asig->id, 'grado' => $gradoAcademico->id, 'ano_lectivo' => $currentAnhoObj->nombre_anho_escolar]) }}" 
                                       class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" style="font-size: 0.75rem;">
                                       <i class="fa fa-edit me-1"></i> Calificar
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- 2. Otras Asignaturas --}}
                    @if($otrasAsignaturas->isNotEmpty())
                        <h6 class="text-white-50 mt-4 mb-3 px-2 border-start border-2 border-secondary py-1">
                            <i class="fa fa-users me-2"></i>OTRAS MATERIAS DEL GRADO
                            <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: normal;">Materias impartidas por otros docentes (Modo Supervisión).</small>
                        </h6>
                        @foreach($otrasAsignaturas as $asig)
                            <div class="list-group-item bg-transparent text-white border-secondary py-2 px-2 mb-1 opacity-75">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1" style="font-size: 0.9rem;">{{ $asig->nombre_asignatura }}</h6>
                                        @php
                                            $docenteAsig = $asig->docentes->firstWhere('id', $asig->pivot->docente_id);
                                        @endphp
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa fa-chalkboard-teacher me-1"></i>
                                            {{ $docenteAsig ? $docenteAsig->name : 'Docente sin asignar' }}
                                        </small>
                                    </div>
                                    @if($esAnhoActual)
                                    <a href="{{ route('docente.asignatura.estudiantes', ['asignatura' => $asig->id, 'grado' => $gradoAcademico->id, 'ano_lectivo' => $currentAnhoObj->nombre_anho_escolar]) }}" 
                                       class="btn btn-xs btn-outline-info rounded-pill px-2" style="font-size: 0.65rem;">
                                       <i class="fa fa-eye me-1"></i> Ver Detalle
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($gradoAcademico->asignaturas->isEmpty())
                        <div class="text-center py-4 text-muted border border-secondary border-dashed rounded">
                            @if($esAnhoActual)
                                <i class="fa fa-info-circle me-1"></i> No hay materias asignadas a este grado.
                            @else
                                <i class="fa fa-info-circle me-1"></i> No hay notas registradas para el año {{ $currentAnhoObj->nombre_anho_escolar }}.
                            @endif
                        </div>
                    @endif
                </div>

                @if($esAnhoActual)
                <!-- Quick Associate Section (solo año actual) -->
                <div class="mt-4 pt-3 border-top border-secondary">
                    <h6 class="text-white small mb-3">Vincular Materia Rapidamente</h6>
                    <form action="{{ route('admin.gradoacademico.update', $gradoAcademico->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="nombre_grado" value="{{ $gradoAcademico->nombre_grado }}">
                        <input type="hidden" name="bloque" value="{{ $gradoAcademico->bloque }}">
                        <input type="hidden" name="sede_id" value="{{ $gradoAcademico->sede_id }}">
                        <input type="hidden" name="docente_id" value="{{ $gradoAcademico->docente_id }}">
                        <input type="hidden" name="curso_id" value="{{ $gradoAcademico->curso_id }}">
                        
                        <!-- Keep current subjects -->
                        @foreach($gradoAcademico->asignaturas as $idx => $a)
                            <input type="hidden" name="asignaturas[{{ $idx }}][id]" value="{{ $a->id }}">
                            <input type="hidden" name="asignaturas[{{ $idx }}][docente_id]" value="{{ $a->pivot->docente_id }}">
                        @endforeach

                        <div class="row g-2">
                            <div class="col-8">
                                <select name="asignaturas[{{ $gradoAcademico->asignaturas->count() }}][id]" class="form-select form-select-sm bg-dark text-white border-secondary" required>
                                    <option value="">Elegir materia...</option>
                                    @foreach($allAsignaturas as $a)
                                        <option value="{{ $a->id }}">{{ $a->nombre_asignatura }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-sm btn-info w-100">
                                    <i class="fa fa-plus me-1"></i> Añadir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- MODAL: Matricular Estudiante -->
<div class="modal fade" id="modalMatricular" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.matriculado.store') }}" method="POST">
            @csrf
            <input type="hidden" name="grado_id" value="{{ $gradoAcademico->id }}">
            <input type="hidden" name="anho_escolar_id" value="{{ $currentAnhoObj->id }}">
            <input type="hidden" name="estado" value="activo">
            <input type="hidden" name="fecha_matricula" value="{{ date('Y-m-d') }}">

            <div class="modal-content bg-secondary text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title"><i class="fa fa-user-plus me-2 text-primary"></i>Nueva Matrícula de Estudiante</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info bg-dark border-info text-white small">
                        <i class="fa fa-info-circle me-1"></i> Se matriculará al estudiante en el grado <strong>{{ $gradoAcademico->nombre_grado }}</strong> para el ciclo <strong>{{ $currentAnhoObj->nombre_anho_escolar }}</strong>.
                    </div>
                    
                    <div class="row g-3 mt-2">
                        <div class="col-md-12">
                            <label class="form-label">Seleccionar Estudiante</label>
                            <select name="documento_estudiante" id="select_estudiante_ajax" class="form-select bg-dark text-white border-secondary" required>
                                <option value="">Buscar por nombre o documento...</option>
                            </select>
                        </div>
                        
                        <!-- Campos ocultos para datos de perfil (requeridos si el estudiante es nuevo) -->
                        <input type="hidden" name="documento_estudiante_exists" id="documento_estudiante_exists" value="">
                        <input type="hidden" name="name" id="hidden_name">
                        <input type="hidden" name="fecha_nacimiento_estudiante" id="hidden_fecha_nacimiento">
                        <input type="hidden" name="email" id="hidden_email">
                        <input type="hidden" name="tipo_identificacion_estudiante" id="hidden_tipo_id">
                        <input type="hidden" name="genero_estudiante" id="hidden_genero">
                        <input type="hidden" name="celular_estudiante" id="hidden_celular">
                        <input type="hidden" name="direccion_estudiante" id="hidden_direccion">
                        <input type="hidden" name="curso" value="{{ $gradoAcademico->bloque }}">
                        
                        <!-- Enrollment needs a subject in this app's current logic, 
                             or maybe just a general enrollment? 
                             Checking Matriculado store logic... it requires asignatura_id. 
                             Let's pick the first one by default or show a list. -->
                        <div class="col-md-12">
                            <label class="form-label">Asignatura de Inicio (requerido por sistema)</label>
                            <select name="asignatura_id" class="form-select bg-dark text-white border-secondary" required>
                                @foreach($gradoAcademico->asignaturas as $a)
                                    <option value="{{ $a->id }}">{{ $a->nombre_asignatura }}</option>
                                @endforeach
                                @if($gradoAcademico->asignaturas->isEmpty())
                                    <option value="">¡No hay materias vinculadas!</option>
                                @endif
                            </select>
                            <small class="text-muted">El sistema requiere una asignatura base para crear el vínculo inicial.</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Acudiente Responsable</label>
                            <select name="acudiente_id" class="form-select bg-dark text-white border-secondary" required>
                                <option value="1" selected>Acudiente General (ID: 1)</option>
                                {{-- Otros acudientes pueden ser gestionados mediante edición de matrícula --}}
                            </select>
                            <small class="text-muted">Por defecto se asigna el acudiente institucional. Puede cambiarlo después si es necesario.</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control bg-dark text-white border-secondary" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Guardar Matrícula
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-xs { padding: .125rem .5rem; font-size: .75rem; }
    .list-group-dark .list-group-item:hover { background-color: rgba(255,255,255,0.05); }
    .border-dashed { border-style: dashed !important; }
</style>

@section('scripts')
<script>
    $(document).ready(function() {
        // Alerta de carga para certificados individuales y grupales
        $('.cert-link, .btn-outline-info').on('click', function(e) {
            // Solo si no es un botón de modal o similar
            if($(this).attr('href') && $(this).attr('href') !== '#') {
                Swal.fire({
                    title: 'Generando Certificado',
                    text: 'Estamos procesando el reporte PDF, por favor espere...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        popup: 'bg-light text-dark border-secondary shadow-lg',
                        title: 'text-primary'
                    }
                });
            }
        });

        // Select2 AJAX para Matrícula
        $('#select_estudiante_ajax').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalMatricular'),
            placeholder: 'Buscar por nombre o documento...',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('admin.matriculado.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $('#documento_estudiante_exists').val('1');
            $('#hidden_name').val(data.name);
            $('#hidden_fecha_nacimiento').val(data.fecha_nacimiento);
            $('#hidden_email').val(data.email);
            $('#hidden_tipo_id').val(data.tipo_id);
            $('#hidden_genero').val(data.genero);
            $('#hidden_celular').val(data.celular);
            $('#hidden_direccion').val(data.direccion);
        });
    });
</script>
@endsection
@endsection
