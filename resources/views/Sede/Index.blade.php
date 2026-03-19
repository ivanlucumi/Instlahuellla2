@extends('layouts.Administracion')

@section('title', 'Gestión de Sedes')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 shadow-sm border-start border-4 border-primary">
                <form action="{{ route('admin.sede.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-1">Mostrar</label>
                        <select name="per_page" class="form-select border-0 bg-dark text-white" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 registros</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                        </select>
                    </div>
                    
                    <div class="col-md-7">
                        <label class="text-white-50 small mb-1">Búsqueda rápida</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-0 bg-dark text-white" 
                                   placeholder="Nombre o dirección de la sede..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.sede.index') }}" class="btn btn-outline-light" title="Limpiar Filtros">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('admin.sede.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Nueva
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-6">
        @forelse($sedes as $sede)
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-secondary text-white shadow border-0 h-100">
                    
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-3">
                            <h5 class="fw-bold mb-2">
                                {{ $sede->nombre_sede }}
                            </h5>
                            <span class="badge {{ $sede->estado_sede ? 'bg-success' : 'bg-danger' }}">
                                {{ $sede->estado_sede ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <p class="mb-1"><strong>Descripción:</strong></p>
                            <span class="text-muted">{{ $sede->descripcion_sede }}</span>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código DANE:</strong></p>
                                <span>{{ $sede->codigo_dane_sede }}</span>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1"><strong>Resolución:</strong></p>
                                <span>{{ $sede->resolucion_sede }}</span>
                            </div>

                            <div class="col-12">
                                <p class="mb-1"><strong>Institución:</strong></p>
                                <span class="badge bg-dark">
                                    {{ $sede->institucion->nombre_institucion ?? 'No asignada' }}
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-transparent border-0 text-center pb-3">
                        <a href="{{ route('admin.sede.edit', $sede) }}" 
                           class="btn btn-warning btn-sm px-3 me-2">
                            <i class="fa fa-edit me-1"></i> Editar
                        </a>
                        
                        @if(auth()->user()->hasRol('SUPERADMIN'))
                        <form action="{{ route('admin.sede.destroy', $sede) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('¿Está seguro de eliminar esta sede?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3">
                                <i class="fa fa-trash me-1"></i> Eliminar
                            </button>
                        </form>
                        @endif
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    No hay sedes registradas. 
                    <a href="{{ route('admin.sede.create') }}" class="alert-link">Crear la primera sede</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $sedes->appends(request()->all())->links() }}
    </div>
</div>

@endsection
