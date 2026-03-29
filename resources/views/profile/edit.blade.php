@extends('layouts.Administracion')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="background:#fff !important;">
                <div class="card-body p-4 text-center">
                    @php
                        $nameParts = explode(' ', trim($user->name));
                        $initials = strtoupper(mb_substr($nameParts[0], 0, 1));
                        if (count($nameParts) > 1) {
                            $initials .= strtoupper(mb_substr(end($nameParts), 0, 1));
                        }
                    @endphp
                    <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, #3b82f6, #6366f1); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                        {{ $initials }}
                    </div>
                    <h4 class="mb-1 fw-bold" style="color:#1e293b;">{{ $user->name }}</h4>
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:0.85rem;">
                        {{ $role }}
                    </span>
                    <hr class="my-4 border-light">
                    <div class="text-start">
                        <p class="mb-2 text-muted small uppercase-small fw-bold">Email Institucional</p>
                        <p class="mb-3 fw-semibold" style="color:#334155;">{{ $user->email }}</p>
                        
                        @if($user->new_email)
                            <div class="alert alert-warning border-0 shadow-sm small py-2 rounded-3">
                                <i class="fa fa-info-circle me-1"></i> Cambio pendiente a: <strong>{{ $user->new_email }}</strong>. Revisa tu bandeja de entrada.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4" style="background:#fff !important;">
                <div class="card-body p-4 p-md-5">
                    <h5 class="mb-4 fw-bold" style="color:#1e293b;">
                        <i class="fa fa-user-edit me-2 text-primary"></i> Información Personal
                    </h5>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary uppercase-small">Nombre Completo</label>
                                <input type="text" name="name" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('name', $user->name) }}" required>
                                @error('name')<small class="text-danger ms-3">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary uppercase-small">Correo de Inicio de Sesión</label>
                                <input type="email" name="email" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('email', $user->email) }}" required>
                                <div class="form-text ms-3 small text-muted">Aviso: Seguirás usando este correo para ingresar hasta que confirmes el nuevo.</div>
                                @error('email')<small class="text-danger ms-3">{{ $message }}</small>@enderror
                            </div>

                            @if($user->hasRol('DOCENTE'))
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Género</label>
                                    <select name="genero_docente" class="form-select rounded-pill border-light-subtle px-4 py-2">
                                        <option value="Masculino" {{ old('genero_docente', $profile->genero_docente ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero_docente', $profile->genero_docente ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero_docente', $profile->genero_docente ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                            @elseif($user->hasRol('ESTUDIANTE'))
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Teléfono</label>
                                    <input type="text" name="telefono_estudiante" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('telefono_estudiante', $profile->telefono_estudiante ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Dirección</label>
                                    <input type="text" name="direccion_estudiante" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('direccion_estudiante', $profile->direccion_estudiante ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Género</label>
                                    <select name="genero_estudiante" class="form-select rounded-pill border-light-subtle px-4 py-2">
                                        <option value="Masculino" {{ old('genero_estudiante', $profile->genero_estudiante ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero_estudiante', $profile->genero_estudiante ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero_estudiante', $profile->genero_estudiante ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                            @elseif($user->hasRol('ACUDIENTE'))
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Celular</label>
                                    <input type="text" name="celular_acudiente" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('celular_acudiente', $profile->celular_acudiente ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Dirección</label>
                                    <input type="text" name="direccion_acudiente" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('direccion_acudiente', $profile->direccion_acudiente ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-primary uppercase-small">Parentesco</label>
                                    <input type="text" name="parentesco_acudiente" class="form-control rounded-pill border-light-subtle px-4 py-2" value="{{ old('parentesco_acudiente', $profile->parentesco_acudiente ?? '') }}" required>
                                </div>
                            @endif
                        </div>

                        <h5 class="mb-4 fw-bold" style="color:#1e293b;">
                            <i class="fa fa-shield-alt me-2 text-primary"></i> Cambiar Contraseña
                        </h5>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary uppercase-small">Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control rounded-pill border-light-subtle px-4 py-2" placeholder="Dejar en blanco para no cambiar">
                                @error('password')<small class="text-danger ms-3">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary uppercase-small">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-pill border-light-subtle px-4 py-2">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm fw-bold">
                                <i class="fa fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
