@extends('layouts.Administracion')

@section('title', 'Gestión de Docentes')

@section('content')

<h3 class="mb-4">
    Listado de clases - {{ $grado->nombre_grado }}
    <span class="badge bg-primary fs-6">
        {{ $grado->asignatura->nombre_asignatura ?? 'Sin asignatura' }}
    </span>
</h3>

@if ($estudiantes->isEmpty())
    <div class="alert alert-warning">
        No hay estudiantes matriculados en este grado.
    </div>
@else

<table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Nombre del estudiante</th>
            <th>Email</th>

            {{-- Columnas de Notas --}}
            @for ($i = 1; $i <= 10; $i++)
                <th>Act. {{ $i }}</th>
            @endfor
        </tr>
    </thead>

    <tbody>
        @foreach ($estudiantes as $index => $matricula)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $matricula->estudiante->user->name }}</td>
                <td>{{ $matricula->estudiante->user->email }}</td>

                {{-- Espacios en blanco para notas --}}
                @for ($i = 1; $i <= 10; $i++)
                    <td>
                        <input type="number" 
                               class="form-control form-control-sm text-center"
                               min="0" 
                               max="5" 
                               step="0.1">
                    </td>
                @endfor
            </tr>
        @endforeach
    </tbody>
</table>

@endif


@endsection
