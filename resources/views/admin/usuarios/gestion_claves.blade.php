@extends('layouts.Administracion')

@section('title', 'Gestión de Contraseñas')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background:#fff !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 fw-bold" style="color:#1e293b;">
                            <i class="fa fa-key me-2 text-primary"></i> Gestión de Seguridad y Claves
                        </h4>
                    </div>
                    
                    <form action="{{ route('admin.usuarios.password-reset') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-light-subtle rounded-start-pill px-3">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-light-subtle rounded-end-pill px-4 py-2" 
                                       placeholder="Buscar por nombre, correo, cédula o código..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold">
                                Buscar Usuario
                            </button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0" style="color:#343a40; background:#fff;">
                            <thead style="background:#f8f9fa;">
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th class="py-3 px-4 fw-semibold small uppercase-small text-primary">Usuario / Identificación</th>
                                    <th class="py-3 px-4 fw-semibold small uppercase-small text-primary">Rol</th>
                                    <th class="py-3 px-4 fw-semibold small uppercase-small text-primary">Correo</th>
                                    <th class="py-3 px-4 text-end fw-semibold small uppercase-small text-primary">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usuarios as $u)
                                    <tr class="hover-row" style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                @php
                                                    $nameParts = explode(' ', trim($u->name));
                                                    $initials = strtoupper(mb_substr($nameParts[0], 0, 1));
                                                    if (count($nameParts) > 1) {
                                                        $initials .= strtoupper(mb_substr(end($nameParts), 0, 1));
                                                    }
                                                @endphp
                                                <div class="user-avatar sm" style="width: 32px; height: 32px; font-size: 0.75rem; background: linear-gradient(135deg, #3b82f6, #6366f1); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="color:#1e293b;">{{ $u->name }}</div>
                                                    <small class="text-muted">
                                                        @if($u->estudiante) ID: {{ $u->estudiante->numero_identificacion_estudiante }}
                                                        @elseif($u->docente) Cod: {{ $u->docente->codigo_docente }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            @foreach($u->roles as $rol)
                                                <span class="badge rounded-pill px-2 py-1 small" style="background:#f1f5f9; color:#475569; border:1px solid #e2e8f0;">
                                                    {{ $rol->nombre }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="py-3 px-4" style="color:#64748b; font-size:0.875rem;">{{ $u->email }}</td>
                                        <td class="py-3 px-4 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#resetModal{{ $u->id }}">
                                                <i class="fa fa-key me-1"></i> Restablecer Clave
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="resetModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="modal-title fw-bold">Restablecer Contraseña</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.usuarios.update-password', $u->id) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <div class="modal-body text-start">
                                                                <p class="text-muted small mb-4">Estás a punto de cambiar la clave de acceso para <strong>{{ $u->name }}</strong>.</p>
                                                                
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold text-primary uppercase-small">Nueva Contraseña</label>
                                                                    <input type="password" name="new_password" class="form-control rounded-pill px-4" required minlength="8">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold text-primary uppercase-small">Confirmar Contraseña</label>
                                                                    <input type="password" name="new_password_confirmation" class="form-control rounded-pill px-4" required minlength="8">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0 pt-0">
                                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Confirmar Cambio</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            @if(request('search')) No hay resultados para "{{ request('search') }}"
                                            @else Inicie una búsqueda para gestionar claves.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.uppercase-small { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.06em; font-weight: 600; }
.hover-row { transition: background-color 0.2s ease; }
.hover-row:hover td { background-color: #f8fafc !important; }
</style>
@endsection
