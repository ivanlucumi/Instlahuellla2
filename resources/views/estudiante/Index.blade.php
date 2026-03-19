@extends('layouts.Administracion')

@section('title', 'Gestión de Estudiantes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <!-- Filtros Pro -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-info">
                <form action="{{ route('admin.estudiante.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="text-white small mb-1">Año Lectivo</label>
                        <select name="anho_escolar_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            @foreach($anhos as $anho)
                                <option value="{{ $anho->id }}" @selected(request('anho_escolar_id') == $anho->id || (!$selectedAnhoId && $anho->estado_anho_escolar))>
                                    {{ $anho->nombre_anho_escolar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="text-white small mb-1">Grado</label>
                        <select name="grado_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Todos los Grados</option>
                            @foreach($grados as $g)
                                <option value="{{ $g->id }}" @selected(request('grado_id') == $g->id)>
                                    {{ $g->nombre_grado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label class="text-white small mb-1">Curso/B.</label>
                        <select name="curso" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">...</option>
                            @foreach($cursos as $c)
                                <option value="{{ $c }}" @selected(request('curso') == $c)>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label class="text-white small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="text-white small mb-1">Filtro Asignatura</label>
                        <select name="asignatura_id" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            @foreach($asignaturas as $asig)
                                <option value="{{ $asig->id }}" @selected(request('asignatura_id') == $asig->id)>
                                    {{ $asig->nombre_asignatura }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="text-white small mb-1">Buscador</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-dark text-white border-secondary" 
                                   placeholder="Nombre o Documento..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex gap-1 justify-content-end">
                        <a href="{{ route('admin.estudiante.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.estudiante.import') }}" class="btn btn-success" title="Importar Estudiantes">
                            <i class="fa fa-file-excel"></i>
                        </a>
                        @if(request('grado_id'))
                            <a href="{{ route('admin.certificados.generar-grupo', array_merge(request()->all(), ['grado_id' => request('grado_id'), 'ano_lectivo' => $currentAnho->nombre_anho_escolar])) }}" 
                               class="btn btn-info text-dark fw-bold" target="_blank" title="Reporte del Grupo">
                                <i class="fa fa-file-pdf"></i> PDF
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover text-white">
                        <thead>
                            <tr>
                                <th scope="col">Foto</th>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Curso</th>
                                <th scope="col">Áreas/Materias</th>
                                <th scope="col">Acudiente</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estudiantes as $estudiante)
                                @php
                                    $matricula = $estudiante->matriculasFinales->first();
                                    $materias = $matricula ? $matricula->notasDefinitivas : collect();
                                @endphp
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="{{ asset($estudiante->foto_estudiante) }}" alt="" style="width: 40px; height: 40px;">
                                    </td>
                                    <td>{{ $estudiante->codigo_estudiante }}</td>
                                    <td>{{ $estudiante->user->name ?? 'N/A' }}</td>
                                    <td>{{ $estudiante->gradoAcademico->nombre_grado ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($matricula)
                                            <span class="badge bg-primary">{{ $matricula->curso }}</span>
                                        @else
                                            <span class="text-muted small">Sin curso</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($materias->take(4) as $m)
                                                <span class="badge bg-dark border border-secondary" style="font-size: 0.65rem;">{{ $m->nombre_asignatura }}</span>
                                            @empty
                                                <span class="text-muted small">No asociadas</span>
                                            @endforelse
                                            @if($materias->count() > 4)
                                                <span class="badge bg-secondary" title="{{ $materias->pluck('nombre_asignatura')->implode(', ') }}" style="font-size: 0.65rem;">
                                                    +{{ $materias->count() - 4 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $estudiante->acudiente->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $estudiante->estado_estudiante ? 'bg-success' : 'bg-danger' }}">
                                            {{ $estudiante->estado_estudiante ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.estudiante.edit', $estudiante) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @if(auth()->user()->hasRol('SUPERADMIN'))
                                            <form action="{{ route('admin.estudiante.destroy', $estudiante) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">No hay estudiantes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $estudiantes->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
