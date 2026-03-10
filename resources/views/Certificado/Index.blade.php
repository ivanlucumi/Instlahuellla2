@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-md-8">
            <div class="bg-secondary rounded h-100 p-4 shadow-sm">
                <div class="d-flex align-items-center mb-4">
                    <i class="fa fa-file-pdf fa-2x text-primary me-3"></i>
                    <h6 class="mb-0 text-white">Generar Certificado de Notas Oficial</h6>
                </div>
                
                <p class="text-white-50 small mb-4">Seleccione el estudiante y el año académico para procesar el certificado oficial de calificaciones en formato PDF.</p>
                
                <form action="{{ route('admin.certificados.generar') }}" method="GET" target="_blank">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="identificacion" class="form-label text-white fw-bold">Buscar Estudiante (Nombre o Identificación)</label>
                            <select name="identificacion" id="identificacion" class="form-select select2 @error('identificacion') is-invalid @enderror" required>
                                <option value="">Seleccione o escriba...</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante['identificacion'] }}">
                                        {{ $estudiante['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="grado_aprobado" class="form-label text-white fw-bold">Grado Académico</label>
                            <select name="grado_aprobado" id="grado_aprobado" class="form-select @error('grado_aprobado') is-invalid @enderror" required>
                                <option value="">Seleccione el grado...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}">
                                        {{ $grado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado_aprobado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary py-3">
                            <i class="fa fa-print me-2"></i> Procesar y Generar PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="alert alert-dark mt-4 border-0 shadow-sm d-flex align-items-center" style="background-color: rgba(0,0,0,0.2);">
                <i class="fa fa-info-circle fa-2x text-info me-3"></i>
                <div class="text-white-50 small">
                    <strong>Nota Importante:</strong> El reporte consolidará todas las calificaciones registradas en los periodos académicos vinculados al año seleccionado. Asegúrese de que las notas estén completas antes de emitir el certificado.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // La inicialización de Select2 ya se encuentra en el layout principal (Administracion.blade.php)
    });
</script>
@endsection
