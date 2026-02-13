@extends('layouts.Administracion')

@section('title', 'Gestión de Docentes')

@section('content')
@forelse ($grados as $grado)
    <div class="mb-4 border rounded p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">{{ $grado->nombre_grado }}</h5>

            <a href="{{ route('docente.listado.clases', $grado->id) }}" 
               class="btn btn-sm btn-primary">
                Listado de clases
            </a>
        </div>

        @if ($asignaturas->isEmpty())
            <p class="text-muted mt-2">Sin asignaturas</p>
        @else
            <ul class="mt-2">
                @foreach ($asignaturas as $asignatura)
                    <li>{{ $asignatura->nombre_asignatura }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@empty
    <p>No hay grados asignados</p>
@endforelse


@endsection
