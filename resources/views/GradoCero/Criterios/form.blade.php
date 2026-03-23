{{-- create.blade.php / edit.blade.php logic --}}
@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">{{ isset($criterio) ? 'Editar' : 'Nuevo' }} Criterio Grado Cero</h6>
                <form action="{{ isset($criterio) ? route('admin.grado-cero.criterios.update', $criterio->id) : route('admin.grado-cero.criterios.store') }}" method="POST">
                    @csrf
                    @if(isset($criterio)) @method('PUT') @endif
                    
                    <div class="mb-3">
                        <label for="asignatura_id" class="form-label">Asignatura</label>
                        <select name="asignatura_id" class="form-select bg-dark text-white border-0" id="asignatura_id" required>
                            @foreach($asignaturas as $asig)
                                <option value="{{ $asig->id }}" {{ (isset($criterio) && $criterio->asignatura_id == $asig->id) ? 'selected' : '' }}>
                                    {{ $asig->nombre_asignatura }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_criterio" class="form-label">Criterio / Logro (Descripción)</label>
                        <textarea name="nombre_criterio" class="form-control bg-dark text-white border-0" id="nombre_criterio" rows="3" required>{{ $criterio->nombre_criterio ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" class="form-select bg-dark text-white border-0" id="estado">
                            <option value="1" {{ (isset($criterio) && $criterio->estado == 1) ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ (isset($criterio) && $criterio->estado == 0) ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($criterio) ? 'Actualizar' : 'Guardar' }}</button>
                    <a href="{{ route('admin.grado-cero.criterios.index') }}" class="btn btn-outline-light">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
