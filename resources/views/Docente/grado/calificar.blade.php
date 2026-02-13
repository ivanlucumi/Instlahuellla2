@extends('layouts.Administracion')

@section('title', 'Gestión de Docentes')

@section('content')
<form action="{{ route('docente.guardarNotas') }}" method="POST">
    @csrf

    <input type="hidden" name="grado_id" value="{{ $grado->id }}">
    <input type="hidden" name="asignatura_id" value="{{ $grado->asignatura_id }}">
    <input type="hidden" name="periodo_academico_id" value="1">

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Nota</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $index => $matricula)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $matricula->estudiante->user->name }}
                    </td>

                    <td>
                        <input type="number"
                               name="notas[{{ $matricula->estudiante->id }}][nota]"
                               class="form-control"
                               min="0"
                               max="5"
                               step="0.1"
                               required>
                    </td>

                    <td>
                        <textarea
                            name="notas[{{ $matricula->estudiante->id }}][observaciones]"
                            class="form-control"
                            rows="1"
                            placeholder="Opcional..."></textarea>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">
        Guardar Calificaciones
    </button>
</form>



@endsection

