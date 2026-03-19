@extends('layouts.Administracion')

@section('title', 'Importar Estudiantes')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="text-dark fw-bold mb-1">Importación Masiva de Estudiantes</h4>
            <p class="text-muted small">Cargue un archivo CSV con la estructura del Excel proporcionado.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.estudiante.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fa fa-arrow-left me-1"></i> Volver a Listado
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.estudiante.import.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold text-dark">Seleccionar Archivo (CSV / Delimitado por punto y coma)</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                            <div class="form-text mt-2">
                                <i class="fa fa-info-circle me-1"></i> Guarde su Excel como <strong>CSV (delimitado por punto y coma)</strong> para procesarlo.
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="fa fa-table me-2"></i> Estructura Requerida:</h6>
                            <p class="small text-muted mb-0">
                                GRADO (Txt); NOMBRE1; NOMBRE2; APELLIDO1; APELLIDO2; DOC; TIPODOC; GENERO; FECHA_NACI (AAAA-MM-DD); GRADO (ID); SEDE (ID); AÑO
                            </p>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                            <i class="fa fa-user-shield fa-2x me-3"></i>
                            <div>
                                <strong>Nota del Sistema:</strong> 
                                Se asignará automáticamente el acudiente con identificación <strong>1111111111</strong> por defecto.
                                La contraseña del usuario creado será su mismo número de documento.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 mt-3">
                            <i class="fa fa-upload me-2"></i> Iniciar Importación
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="card-title fw-bold text-dark mb-0">Ayuda de Formato</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fa fa-check-circle text-success mt-1 me-2"></i>
                            <span>Use el formato <strong>AAAA-MM-DD</strong> para la fecha de nacimiento.</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fa fa-check-circle text-success mt-1 me-2"></i>
                            <span>Los IDs de Grado y Sede deben existir en el sistema.</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fa fa-check-circle text-success mt-1 me-2"></i>
                            <span>Si el estudiante ya existe (por documento), sus datos se actualizarán.</span>
                        </li>
                    </ul>
                    
                    <div class="mt-4 pt-3 border-top">
                        <p class="small fw-bold text-dark mb-2 text-uppercase">Valores sugeridos:</p>
                        <code class="d-block bg-dark text-white p-2 rounded mb-1">SEXTO; ANDREI; SEBASTIAN; ASCUE; TOMBE; 1061438170; TI; MASCULINO; 2014-10-07; 7; 1; 2026</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
