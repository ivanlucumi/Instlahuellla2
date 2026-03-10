@extends('layouts.Administracion')

@section('title', 'Historial Académico')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-white">Mi Historial Académico</h4>
            <p class="text-muted">Consulta tus calificaciones de todos los años cursados.</p>
        </div>
    </div>

    @forelse($matriculas as $matricula)
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-secondary rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 text-white">
                            <i class="fa fa-calendar-alt text-primary me-2"></i>
                            Año: {{ $matricula->anhoEscolar->nombre_anho_escolar ?? 'N/A' }} 
                            <span class="ms-3 text-muted">|</span> 
                            <small class="ms-3">Grado: {{ $matricula->grado->nombre_grado ?? 'N/A' }} - {{ $matricula->grado->bloque ?? '' }}</small>
                        </h5>
                        <span class="badge bg-primary">{{ $matricula->estado }}</span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-white">
                            <thead class="bg-dark">
                                <tr>
                                    <th>Asignatura</th>
                                    <th class="text-center">P1</th>
                                    <th class="text-center">P2</th>
                                    <th class="text-center">P3</th>
                                    <th class="text-center">P4</th>
                                    <th class="text-center">Definitiva</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($matricula->notas as $nota)
                                    <tr>
                                        <td>{{ $nota->asignatura->nombre_asignatura }}</td>
                                        <td class="text-center">{{ $nota->nota1 ?? '-' }}</td>
                                        <td class="text-center">{{ $nota->nota2 ?? '-' }}</td>
                                        <td class="text-center">{{ $nota->nota3 ?? '-' }}</td>
                                        <td class="text-center">{{ $nota->nota4 ?? '-' }}</td>
                                        <td class="text-center fw-bold {{ ($nota->nota_definitiva >= 3) ? 'text-success' : 'text-danger' }}">
                                            {{ $nota->nota_definitiva ?? '-' }}
                                        </td>
                                        <td><small>{{ $nota->observaciones ?? 'Sin observaciones' }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay notas registradas para este año.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    No tienes registros de matrículas en el sistema.
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
