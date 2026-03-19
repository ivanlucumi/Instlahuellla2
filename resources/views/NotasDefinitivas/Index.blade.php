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
                                @if(auth()->user()->hasRol('SUPERADMIN'))
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
                                    @if(auth()->user()->hasRol('SUPERADMIN'))
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.notas-definitivas.edit', $nota->id) }}" 
                                                   class="btn btn-sm btn-warning me-1"
                                                   title="Editar">
                                                    <i class="fa fa-pen"></i>
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
                                                        <i class="fa fa-trash"></i>
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
@endsection
