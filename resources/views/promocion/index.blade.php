@extends('layouts.Administracion')

@section('title', 'Promoción de Grado')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden transition-all" style="background:#fff !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 fw-bold" style="color:#1e293b;">
                            <i class="fa fa-graduation-cap me-2 text-primary"></i> Promoción de Grado
                        </h4>
                    </div>
                    
                    <p class="mb-4" style="color:#64748b; font-size:0.9rem;">
                        Seleccione un grado para revisar las calificaciones finales y formalizar la promoción académica.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle transition-table" style="color:#343a40; background:#fff;">
                            <thead style="background:#f8f9fa;">
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th scope="col" class="py-3 fw-semibold small uppercase-small" style="color:#3b82f6;">Detalle del Grado</th>
                                    <th scope="col" class="py-3 fw-semibold small uppercase-small" style="color:#3b82f6;">Sede</th>
                                    <th scope="col" class="py-3 fw-semibold small uppercase-small" style="color:#3b82f6;">Curso</th>
                                    <th scope="col" class="py-3 fw-semibold small uppercase-small" style="color:#3b82f6;">Estudiantes</th>
                                    <th scope="col" class="py-3 text-end fw-semibold small uppercase-small" style="color:#3b82f6;">Operación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grados as $g)
                                    <tr class="hover-row" style="border-bottom: 1px solid #f1f5f9;">
                                        <td>
                                            <div class="fw-bold" style="color:#1e293b;">{{ $g->nombre_grado }}</div>
                                            <small style="color:#94a3b8;">{{ $g->bloque }}</small>
                                        </td>
                                        <td><span style="color:#64748b; font-size:0.875rem;">{{ $g->sede->nombre_sede ?? 'Sin Sede' }}</span></td>
                                        <td><span style="color:#64748b; font-size:0.875rem;">{{ $g->curso->nombre_curso ?? 'N/A' }}</span></td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2" style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:0.8rem;">
                                                {{ $g->estudiantes->count() }} alumnos
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.promocion.show', $g->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm" style="font-size:0.875rem;">
                                                <i class="fa fa-layer-group me-1"></i> Gestionar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted opacity-50">
                                                <i class="fa fa-folder-open fa-2x mb-3 d-block"></i>
                                                No hay grados asignados para promoción.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.uppercase-small { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.06em; font-weight: 600; }
.hover-row { transition: background-color 0.2s ease; }
.hover-row:hover { background-color: #eff6ff !important; }
.transition-all { transition: all 0.3s ease; }
</style>
@endsection
