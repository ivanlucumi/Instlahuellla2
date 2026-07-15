@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    {{-- Filtros --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <form action="{{ route('admin.notas-definitivas.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="text-white-50 small mb-1">Buscador Estudiante</label>
                        <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                               placeholder="Nombre o Documento..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Grado</label>
                        <select name="grado_aprobado" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Todos los Grados</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}" {{ request('grado_aprobado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label class="text-white-50 small mb-1">Curso</label>
                        <select name="curso" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">...</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso }}" {{ request('curso') == $curso ? 'selected' : '' }}>{{ $curso }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="text-white-50 small mb-1">Asignatura</label>
                        <select name="nombre_asignatura" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="">Todas las Asignaturas</option>
                            @foreach($asignaturas as $asig)
                                <option value="{{ $asig }}" {{ request('nombre_asignatura') == $asig ? 'selected' : '' }}>{{ $asig }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <a href="{{ route('admin.notas-definitivas.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        @if(auth()->user()->hasRol('SUPERADMIN'))
                            <a href="{{ route('admin.notas-definitivas.create') }}" class="btn btn-primary d-flex align-items-center">
                                <i class="fa fa-plus me-1"></i> Nuevo
                            </a>
                            <button type="button" class="btn btn-danger d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalLimpiezaMasiva" title="Eliminar todas las notas de una asignatura en un grado">
                                <i class="fa fa-trash-alt me-1"></i> Limpieza Masiva
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Histórico de Notas Definitivas</h6>
                </div>

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Doc.</th>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Cur.</th>
                                <th scope="col">Asignatura</th>
                                <th scope="col" class="text-center">P1</th>
                                <th scope="col" class="text-center">P2</th>
                                <th scope="col" class="text-center">P3</th>
                                <th scope="col" class="text-center">P4</th>
                                <th scope="col" class="text-center">Def.</th>
                                @if(auth()->user()->hasRol('SUPERADMIN1'))
                                    <th scope="col">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notasDefinitivas as $nota)
                                <tr>
                                    <td><small>{{ $nota->documento_estudiante }}</small></td>
                                    <td>{{ $nota->nombre_estudiante }}</td>
                                    <td>{{ $nota->grado_aprobado }}</td>
                                    <td>{{ $nota->curso }}</td>
                                    <td>{{ $nota->nombre_asignatura }}</td>
                                    <td class="text-center">{{ $nota->nota_per1 }}</td>
                                    <td class="text-center">{{ $nota->nota_per2 }}</td>
                                    <td class="text-center">{{ $nota->nota_per3 }}</td>
                                    <td class="text-center">{{ $nota->nota_per4 }}</td>
                                    <td class="text-center fw-bold text-primary">{{ $nota->nota_definitiva }}</td>
                                    @if(auth()->user()->hasRol('SUPERADMIN1'))
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.notas-definitivas.edit', $nota->id) }}" 
                                                   class="btn btn-sm btn-warning me-1"
                                                   title="Editar">
                                                    <i class="fa fa-pen" disabled></i>
                                                </a>
                                                
                                                <form action="{{ route('admin.notas-definitivas.destroy', $nota->id) }}" 
                                                      method="POST" 
                                                      class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            title="Eliminar"
                                                            onclick="return confirm('¿Está seguro de eliminar este registro?')">
                                                        <i class="fa fa-trash" disabled></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-white-50">
                                        <i class="fa fa-info-circle me-2"></i> No hay registros históricos coincidentes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación y Selector inferior derecho --}}
                <div class="row mt-4 align-items-center">
                    <div class="col-md-6">
                        {{ $notasDefinitivas->appends(request()->all())->links() }}
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center gap-2">
                        <span class="text-white-50 small">Mostrar:</span>
                        <form action="{{ route('admin.notas-definitivas.index') }}" method="GET" style="width: 120px;">
                            {{-- Preservar otros filtros --}}
                            @foreach(request()->except('per_page', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="per_page" class="form-select form-select-sm border-0 bg-dark text-white" onchange="this.form.submit()">
                                <option value="80" {{ request('per_page', 80) == 80 ? 'selected' : '' }}>80 registros</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 registros</option>
                                <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500 registros</option>
                                <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000 registros</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal: Limpieza Masiva - Solo SUPERADMIN -->
    @if(auth()->user()->hasRol('SUPERADMIN'))
    <div class="modal fade" id="modalLimpiezaMasiva" tabindex="-1" aria-labelledby="modalLimpiezaMasivaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border border-danger">
                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger" id="modalLimpiezaMasivaLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i> Limpieza Masiva de Notas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('admin.notas-definitivas.bulk-delete') }}" method="POST" id="formLimpiezaMasiva">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger small mb-3">
                            <i class="fa fa-exclamation-circle me-1"></i>
                            <strong>¡Acción irreversible!</strong> Esta operación eliminará permanentemente <strong>todos</strong> los registros de la asignatura seleccionada para el grado indicado.
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small">Grado a Limpiar</label>
                            <select name="grado_aprobado" id="bulk_grado" class="form-select bg-dark text-white border-secondary" required>
                                <option value="">— Seleccione un Grado —</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}">{{ $grado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small">Asignatura a Eliminar</label>
                            <select name="nombre_asignatura" id="bulk_asignatura" class="form-select bg-dark text-white border-secondary" required>
                                <option value="">— Seleccione una Asignatura —</option>
                                @foreach($asignaturas as $asig)
                                    <option value="{{ $asig }}">{{ $asig }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-white-50 small">Confirmar escribiendo <span class="text-danger fw-bold">ELIMINAR</span>:</label>
                            <input type="text" id="confirmacionTexto" class="form-control bg-dark text-white border-secondary" placeholder="Escriba ELIMINAR para confirmar">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnConfirmarLimpieza" class="btn btn-danger" disabled>
                            <i class="fa fa-trash me-1"></i> Confirmar Eliminación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.getElementById('confirmacionTexto')?.addEventListener('input', function() {
            const btn = document.getElementById('btnConfirmarLimpieza');
            btn.disabled = this.value.trim() !== 'ELIMINAR';
        });
    </script>
@endsection
