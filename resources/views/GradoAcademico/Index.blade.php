@extends('layouts.Administracion')

@section('title', 'Gestión de Grados Académicos')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="text-white mb-0">
                <i class="fa fa-graduation-cap me-2 text-primary"></i>
                Grados Académicos Registrados
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.gradoacademico.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>Grado
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-3 shadow-sm">
                <form action="{{ route('admin.gradoacademico.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <select name="grado_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Seleccionar Grado</option>
                            @foreach($allGrados as $g)
                                <option value="{{ $g->id }}" @selected(request('grado_id') == $g->id)>
                                    {{ $g->nombre_grado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select name="curso_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Curso...</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" @selected(request('curso_id') == $curso->id)>
                                    {{ $curso->nombre_curso }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="anho_escolar_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Año Lectivo</option>
                            @foreach($anhos as $anho)
                                <option value="{{ $anho->id }}" @selected(request('anho_escolar_id') == $anho->id)>
                                    {{ $anho->nombre_anho_escolar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="asignatura_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Asignatura...</option>
                            @foreach($asignaturas as $asig)
                                <option value="{{ $asig->id }}" @selected(request('asignatura_id') == $asig->id)>
                                    {{ $asig->nombre_asignatura }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <select name="per_page" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-1">
                        <button type="submit" class="btn btn-info shadow-sm flex-grow-1">
                            <i class="fa fa-search me-1"></i> Buscar
                        </button>

                        @if(request()->anyFilled(['grado_id', 'curso_id', 'anho_escolar_id', 'asignatura_id']))
                            <a href="{{ route('admin.gradoacademico.index') }}" class="btn btn-outline-warning" title="Limpiar Filtros">
                                <i class="fa fa-sync-alt"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($searchSummary)
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info bg-dark border-info text-white d-flex align-items-center mb-0">
                <i class="fa fa-search me-2 text-info"></i>
                <div>
                    <span class="fw-bold">Mostrando resultados para:</span> 
                    <span class="ms-1">{{ $searchSummary }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($enrollmentsResults)
    <div class="row mt-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">
                        <i class="fa fa-user-graduate me-2 text-primary"></i>
                        Estudiantes Enrolados y Calificaciones Históricas
                    </h5>
                    @if(request('asignatura_id'))
                        <span class="badge bg-info p-2">Asignatura: {{ $asignaturas->find(request('asignatura_id'))->nombre_asignatura }}</span>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-white align-middle">
                        <thead class="bg-dark text-info">
                            <tr>
                                <th>Estudiante</th>
                                <th>Identificación</th>
                                <th class="text-center">P1</th>
                                <th class="text-center">P2</th>
                                <th class="text-center">P3</th>
                                <th class="text-center">P4</th>
                                <th class="text-center">Definitiva</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollmentsResults as $enrollment)
                                @php
                                    $estudiante = $enrollment->estudiante;
                                    $nota = $enrollment->notaResult;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white">{{ $estudiante->user->name ?? 'Estudiante no encontrado' }}</div>
                                        <small class="text-muted">{{ $enrollment->ano_lectivo }}</small>
                                    </td>
                                    <td>{{ $enrollment->documento_estudiante }}</td>
                                    <td class="text-center">{{ $nota->nota_per1 ?? '0.00' }}</td>
                                    <td class="text-center">{{ $nota->nota_per2 ?? '0.00' }}</td>
                                    <td class="text-center">{{ $nota->nota_per3 ?? '0.00' }}</td>
                                    <td class="text-center">{{ $nota->nota_per4 ?? '0.00' }}</td>
                                    <td class="text-center">
                                        @php
                                            $defVal = (float)($nota->nota_definitiva ?? 0);
                                            $rawPeriods = [$nota->nota_per1 ?? 0, $nota->nota_per2 ?? 0, $nota->nota_per3 ?? 0, $nota->nota_per4 ?? 0];
                                            $validPeriods = array_filter($rawPeriods, fn($n) => is_numeric($n) && (float)$n > 0);
                                        @endphp
                                        @if(count($validPeriods) >= 3 || $defVal > 0)
                                            <span class="badge {{ $defVal >= 3 ? 'bg-success' : 'bg-danger' }} rounded-pill" title="{{ count($validPeriods) }} periodos promediados">
                                                {{ number_format($defVal, 1) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill opacity-75" title="Se requieren al menos 3 periodos (P4 es opcional)">Pnd.</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $isHistorical = ($enrollment->ano_lectivo != $currentAnho);
                                            $canCalificar = !$isHistorical || auth()->user()->hasRol('SUPERADMIN');
                                        @endphp

                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            @if(request('asignatura_id') && $estudiante)
                                                @if($canCalificar)
                                                    <a href="{{ route('docente.asignatura.estudiantes', ['asignatura' => request('asignatura_id'), 'grado' => request('grado_id'), 'ano_lectivo' => $enrollment->ano_lectivo]) }}" 
                                                       class="btn btn-sm {{ $isHistorical ? 'btn-outline-warning' : 'btn-outline-info' }}" title="Administrar Notas">
                                                        <i class="fa fa-edit"></i> {{ $isHistorical ? 'Rectificar' : 'Calificar' }}
                                                    </a>
                                                @else
                                                    <span class="badge bg-dark text-muted" title="Solo SuperAdmin puede editar años anteriores">
                                                        <i class="fa fa-lock me-1"></i> Histórico
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-dark text-muted">Ajuste filtros</span>
                                            @endif

                                            {{-- Botón Certificado por id_matricula --}}
                                            <a href="{{ route('admin.certificados.por-matricula', $enrollment->id) }}"
                                               class="btn btn-sm btn-outline-success" title="Descargar Certificado de Notas">
                                                <i class="fa fa-file-pdf"></i> Cert.
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">No se encontraron registros históricos para los criterios seleccionados.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-5 border-white opacity-25">
    @endif

    <div class="row">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h5 class="text-white mb-4">Grados Académicos Registrados</h5>
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Bloque</th>
                                <th scope="col">Curso</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Director</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grados as $grado)
                                <tr>
                                    <th scope="row">{{ ($grados->currentPage() - 1) * $grados->perPage() + $loop->iteration }}</th>
                                    <td>{{ $grado->nombre_grado }}</td>
                                    <td>{{ $grado->bloque }}</td>
                                    <td>{{ $grado->curso->nombre_curso ?? 'N/A' }}</td>
                                    <td>{{ $grado->sede->nombre_sede ?? 'N/A' }}</td>
                                    <td>{{ $grado->docente->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $grado->estado_grado_academico ? 'bg-success' : 'bg-danger' }}">
                                            {{ $grado->estado_grado_academico ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.gradoacademico.show', $grado) }}" 
                                           class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.gradoacademico.edit', $grado) }}" 
                                           class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <form action="{{ route('admin.gradoacademico.destroy', $grado) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este grado académico?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                            No hay grados académicos registrados.
                                            <a href="{{ route('admin.gradoacademico.create') }}" class="alert-link">Crear el primer grado</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($grados->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $grados->appends(request()->all())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
