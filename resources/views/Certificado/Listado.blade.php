@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-md-10">
            <div class="bg-white rounded h-100 p-4 shadow-sm border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-history fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="mb-0 text-dark">Múltiples Registros Encontrados</h5>
                            <p class="text-muted small mb-0">El estudiante es repitente o tiene varios registros activos para el grado <strong>{{ $grado_nombre }}</strong>.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.certificados.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Volver al buscador
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Año Lectivo</th>
                                <th>Sede</th>
                                <th>Curso/Grupo</th>
                                <th>Director de Grupo</th>
                                <th>Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriculas as $mat)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $mat->ano_lectivo }}</td>
                                    <td>{{ $mat->sede->nombre_sede ?? 'Sede Principal' }}</td>
                                    <td>{{ $mat->curso ?? '1' }}</td>
                                    <td>{{ $mat->profesor->name ?? 'No asignado' }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $mat->estado }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.certificados.generar') }}" method="GET" class="gen-form">
                                            <input type="hidden" name="identificacion" value="{{ $estudiante->numero_identificacion_estudiante }}">
                                            <input type="hidden" name="grado_aprobado" value="{{ $grado_nombre }}">
                                            <input type="hidden" name="matricula_id" value="{{ $mat->id }}">
                                            
                                            <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">
                                                <i class="fa fa-file-pdf me-1"></i> Generar Este Año
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info small mt-4">
                    <i class="fa fa-info-circle me-2"></i> Seleccione el año lectivo específico que desea certificar. El sistema generará el informe valorativo con las notas correspondientes a ese periodo académico seleccionado.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.gen-form').on('submit', function() {
            Swal.fire({
                title: 'Generando Certificado',
                text: 'Procesando calificaciones del año seleccionado...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'bg-light text-dark border-secondary shadow-lg',
                    title: 'text-primary'
                }
            });
        });
    });
</script>
@endsection
