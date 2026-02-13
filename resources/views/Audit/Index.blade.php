@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Auditoría del Sistema</h6>
                
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Fecha</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Evento</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">ID Modelo</th>
                                <th scope="col">IP</th>
                                <th scope="col">Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audits as $audit)
                                <tr>
                                    <td>{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $audit->user->name ?? 'Sistema' }}</td>
                                    <td>
                                        @if($audit->event == 'created') <span class="badge bg-success">Creación</span>
                                        @elseif($audit->event == 'updated') <span class="badge bg-primary">Edición</span>
                                        @elseif($audit->event == 'deleted') <span class="badge bg-danger">Eliminación</span>
                                        @else {{ $audit->event }} @endif
                                    </td>
                                    <td>{{ class_basename($audit->auditable_type) }}</td>
                                    <td>{{ $audit->auditable_id }}</td>
                                    <td>{{ $audit->ip_address }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#auditModal{{ $audit->id }}">
                                            <i class="fa fa-eye"></i> Ver
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="auditModal{{ $audit->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content bg-secondary">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detalles de Auditoría #{{ $audit->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Valores Anteriores</h6>
                                                                <pre class="bg-dark p-2 rounded text-white" style="max-height: 200px; overflow-y: auto;">{{ json_encode(json_decode($audit->old_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Valores Nuevos</h6>
                                                                <pre class="bg-dark p-2 rounded text-white" style="max-height: 200px; overflow-y: auto;">{{ json_encode(json_decode($audit->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <p><strong>URL:</strong> {{ $audit->url }}</p>
                                                        <p><strong>User Agent:</strong> {{ $audit->user_agent }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay registros de auditoría.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
