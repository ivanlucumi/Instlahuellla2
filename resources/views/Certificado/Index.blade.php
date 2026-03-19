@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-md-8">
            <div class="bg-white rounded h-100 p-4 shadow-sm border-top border-4 border-primary">
                <div class="d-flex align-items-center mb-4">
                    <i class="fa fa-file-pdf fa-2x text-primary me-3"></i>
                    <h6 class="mb-0 text-dark">Generar Certificado de Notas Oficial</h6>
                </div>
                
                <p class="text-muted small mb-4">Seleccione el estudiante y el grado académico para descargar el informe oficial de calificaciones.</p>
                
                <form action="{{ route('admin.certificados.generar') }}" method="GET" id="certForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="identificacion" class="form-label text-dark fw-bold">Buscar Estudiante (Nombre o Identificación)</label>
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
                            <label for="grado_aprobado" class="form-label text-dark fw-bold">Grado Académico</label>
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
                            <i class="fa fa-search me-2"></i> Consultar Disponibilidad
                        </button>
                    </div>
                </form>
            </div>

            <div class="alert alert-light mt-4 border-0 shadow-sm d-flex align-items-center">
                <i class="fa fa-info-circle fa-2x text-info me-3"></i>
                <div class="text-muted small">
                    <strong>Nota Importante:</strong> El sistema buscará todos los registros académicos asociados al grado seleccionado. Si el estudiante es repitente, se mostrarán las opciones disponibles para que elija el año lectivo que desea certificar. Solo se permiten certificados de matrículas que no estén en estado "Retirado".
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#certForm').on('submit', function() {
            Swal.fire({
                title: 'Consultando Registros',
                text: 'Espere un momento mientras buscamos la información académica...',
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
