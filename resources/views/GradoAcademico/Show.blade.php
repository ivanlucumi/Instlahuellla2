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
                    <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0 gap-2">
                        <form action="{{ route('admin.gradoacademico.show', $gradoAcademico->id) }}" method="GET" class="d-flex align-items-center gap-2">
                            <label class="text-white small text-nowrap">Año Lectivo:</label>
                            <select name="anho_escolar_id" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="this.form.submit()" style="width: 130px;">
                                @foreach($anhos as $anho)
                                    <option value="{{ $anho->id }}" @selected($currentAnhoObj->id == $anho->id)>
                                        {{ $anho->nombre_anho_escolar }}
                                    </option>
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

        <!-- Left Column: Students -->
        <div class="col-sm-12 col-xl-7">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">
                        <i class="fa fa-users me-2 text-primary"></i> Estudiantes en {{ $currentAnhoObj->nombre_anho_escolar }}
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.certificados.generar-grupo', [
                            'grado_id' => $gradoAcademico->id, 
                            'ano_lectivo' => $currentAnhoObj->nombre_anho_escolar,
                            'curso' => ($gradoAcademico->curso->nombre_curso ?? $gradoAcademico->bloque)
                        ]) }}" 
                           class="btn btn-sm btn-outline-info" target="_blank">
                            <i class="fa fa-file-pdf me-1"></i> Certificado Grupal
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalMatricular">
                            <i class="fa fa-user-plus me-1"></i> Matricular
                        </button>
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
                                                    <a class="dropdown-item text-info" target="_blank"
                                                       href="{{ route('admin.certificados.generar', ['identificacion' => $est->numero_identificacion_estudiante, 'grado_aprobado' => ($gradoAcademico->nombre_grado . ' - ' . $gradoAcademico->bloque)]) }}">
                                                        <i class="fa fa-file-pdf me-2"></i>Generar Certificado
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fa fa-trash me-2"></i>Retirar</a></li>
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
                        <i class="fa fa-book-open me-2 text-primary"></i> Asignaturas Vinculadas
                    </h5>
                    <a href="{{ route('admin.gradoacademico.edit', $gradoAcademico->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-cog me-1"></i> Gestionar
                    </a>
                </div>
                
                <div class="list-group list-group-flush list-group-dark">
                    @forelse($gradoAcademico->asignaturas as $asig)
                        <div class="list-group-item bg-transparent text-white border-secondary py-3 px-0">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-info">{{ $asig->nombre_asignatura }}</h6>
                                    @php
                                        $docente = $asig->docentes->firstWhere('id', $asig->pivot->docente_id);
                                    @endphp
                                    <small class="d-block text-white-50">
                                        <i class="fa fa-calendar-alt me-1"></i> Ciclo: {{ $currentAnhoObj->nombre_anho_escolar }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fa fa-chalkboard-teacher me-1"></i>
                                        {{ $docente ? $docente->name : 'Docente sin asignar' }}
                                    </small>
                                </div>
                                <a href="{{ route('docente.asignatura.estudiantes', ['asignatura' => $asig->id, 'grado' => $gradoAcademico->id, 'ano_lectivo' => $currentAnhoObj->nombre_anho_escolar]) }}" 
                                   class="btn btn-xs btn-outline-info rounded-pill px-3" style="font-size: 0.7rem;">
                                   Planilla <i class="fa fa-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted border border-secondary border-dashed rounded">
                            No hay materias asignadas a este grado.
                        </div>
                    @endforelse
                </div>

                <!-- Quick Associate Section -->
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
                            <select name="estudiante_id" class="form-select bg-dark text-white border-secondary select2-modal" required>
                                <option value="">Buscar por nombre o documento...</option>
                                @foreach($estudiantesDisponibles as $e)
                                    <option value="{{ $e->id }}">
                                        {{ $e->user->name }} ({{ $e->numero_identificacion_estudiante }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
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
                                <option value="1">Acudiente General</option>
                                @foreach($estudiantesDisponibles->take(10) as $e)
                                    @if($e->acudiente)
                                        <option value="{{ $e->acudiente_id }}">Padre/Madre de {{ $e->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
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

@endsection
