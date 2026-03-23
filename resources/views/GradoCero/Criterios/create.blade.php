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
                        <label for="asignatura_id" class="form-label fw-bold">Asignatura (Dimensión)</label>
                        <select name="asignatura_id" class="form-select bg-dark text-white border-0" id="asignatura_id" required>
                            @foreach($asignaturas as $asig)
                                <option value="{{ $asig->id }}" {{ (isset($criterio) && $criterio->asignatura_id == $asig->id) ? 'selected' : '' }}>
                                    {{ $asig->nombre_asignatura }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(!isset($criterio))
                    <div class="mb-3">
                        <label class="form-label fw-bold">Criterios / Logros</label>
                        <div id="criterios-container">
                            <div class="input-group mb-2 criterio-item">
                                <input type="text" name="criterios[]" class="form-control bg-dark text-white border-0" placeholder="Descripción del logro..." required>
                                <button type="button" class="btn btn-outline-danger remove-criterio" style="display:none;"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <button type="button" id="add-criterio" class="btn btn-sm btn-outline-info mt-2">
                            <i class="fa fa-plus me-1"></i> Agregar otro logro
                        </button>
                    </div>
                    @else
                    <div class="mb-3">
                        <label for="nombre_criterio" class="form-label fw-bold">Descripción del Criterio</label>
                        <input type="text" name="nombre_criterio" class="form-control bg-dark text-white border-0" value="{{ $criterio->nombre_criterio }}" required>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="estado" class="form-label fw-bold">Estado</label>
                        <select name="estado" class="form-select bg-dark text-white border-0" id="estado">
                            <option value="1" {{ (isset($criterio) && $criterio->estado == 1) ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ (isset($criterio) && $criterio->estado == 0) ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4">{{ isset($criterio) ? 'Actualizar' : 'Guardar Criterios' }}</button>
                        <a href="{{ route('admin.grado-cero.criterios.index') }}" class="btn btn-outline-light">Cancelar</a>
                    </div>
                </form>

                @if(!isset($criterio))
                <script>
                    document.getElementById('add-criterio').addEventListener('click', function() {
                        const container = document.getElementById('criterios-container');
                        const newItem = document.querySelector('.criterio-item').cloneNode(true);
                        newItem.querySelector('input').value = '';
                        newItem.querySelector('.remove-criterio').style.display = 'block';
                        container.appendChild(newItem);
                        
                        newItem.querySelector('.remove-criterio').addEventListener('click', function() {
                            newItem.remove();
                        });
                    });
                </script>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
