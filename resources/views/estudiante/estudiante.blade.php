@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 text-center">

        <div class="col-md-6">
            <button class="btn btn-periodo btn-lg w-100 py-5 shadow rounded-4"
                data-bs-toggle="modal"
                data-bs-target="#modalNotas"
                onclick="cargarPeriodo(1)">
                Primer Periodo
            </button>
        </div>

        <div class="col-md-6">
            <button class="btn btn-periodo btn-lg w-100 py-5 shadow rounded-4"
                data-bs-toggle="modal"
                data-bs-target="#modalNotas"
                onclick="cargarPeriodo(2)">
                Segundo Periodo
            </button>
        </div>

        <div class="col-md-6">
            <button class="btn btn-periodo btn-lg w-100 py-5 shadow rounded-4"
                data-bs-toggle="modal"
                data-bs-target="#modalNotas"
                onclick="cargarPeriodo(3)">
                Tercer Periodo
            </button>
        </div>

        <div class="col-md-6">
            <button class="btn btn-periodo btn-lg w-100 py-5 shadow rounded-4"
                data-bs-toggle="modal"
                data-bs-target="#modalNotas"
                onclick="cargarPeriodo(4)">
                Cuarto Periodo
            </button>
        </div>

    </div>
</div>


@endsection
<!-- Modal -->
<div class="modal fade" id="modalNotas" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tituloPeriodo">Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="contenidoNotas">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function cargarPeriodo(periodo) {
    document.getElementById('tituloPeriodo').innerText =
        `Notas - Periodo ${periodo}`;

    let tablas = {
        1: `{!! view('estudiante.notas.periodo1')->render() !!}`,
        2: `{!! view('estudiante.notas.periodo1')->render() !!}`,
        3: `{!! view('estudiante.notas.periodo1')->render() !!}`,
        4: `{!! view('estudiante.notas.periodo1')->render() !!}`,
    };

    document.getElementById('contenidoNotas').innerHTML = tablas[periodo];
}
</script>
