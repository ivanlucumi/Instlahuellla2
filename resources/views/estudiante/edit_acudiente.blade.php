@extends('layouts.Administracion')

@section('title', 'Actualizar Acudiente')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-white">Actualizar Información de Acudiente</h4>
            <p class="text-muted">Mantén los datos de tu acudiente actualizados para una mejor comunicación con la institución.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="bg-secondary rounded p-4">
                <form action="{{ route('estudiante.acudiente.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-white">Nombre del Acudiente</label>
                        <input type="text" class="form-control bg-dark border-0 text-white" value="{{ $acudiente->user->name ?? 'N/A' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="celular_acudiente" class="form-label text-white">Celular de Contacto</label>
                        <input type="text" name="celular_acudiente" id="celular_acudiente" 
                               class="form-control bg-dark border-0 text-white @error('celular_acudiente') is-invalid @enderror" 
                               value="{{ old('celular_acudiente', $acudiente->celular_acudiente ?? '') }}" required>
                        @error('celular_acudiente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="direccion_acudiente" class="form-label text-white">Dirección de Residencia</label>
                        <input type="text" name="direccion_acudiente" id="direccion_acudiente" 
                               class="form-control bg-dark border-0 text-white @error('direccion_acudiente') is-invalid @enderror" 
                               value="{{ old('direccion_acudiente', $acudiente->direccion_acudiente ?? '') }}" required>
                        @error('direccion_acudiente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="genero_acudiente" class="form-label text-white">Género</label>
                            <select name="genero_acudiente" id="genero_acudiente" class="form-select @error('genero_acudiente') is-invalid @enderror">
                                <option value="Masculino" {{ old('genero_acudiente', $acudiente->genero_acudiente ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero_acudiente', $acudiente->genero_acudiente ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('genero_acudiente', $acudiente->genero_acudiente ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero_acudiente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="parentesco_acudiente" class="form-label text-white">Parentesco</label>
                            <select name="parentesco_acudiente" id="parentesco_acudiente" class="form-select @error('parentesco_acudiente') is-invalid @enderror">
                                <option value="Padre" {{ old('parentesco_acudiente', $acudiente->parentesco_acudiente ?? '') == 'Padre' ? 'selected' : '' }}>Padre</option>
                                <option value="Madre" {{ old('parentesco_acudiente', $acudiente->parentesco_acudiente ?? '') == 'Madre' ? 'selected' : '' }}>Madre</option>
                                <option value="Tutor" {{ old('parentesco_acudiente', $acudiente->parentesco_acudiente ?? '') == 'Tutor' ? 'selected' : '' }}>Tutor</option>
                                <option value="Otro" {{ old('parentesco_acudiente', $acudiente->parentesco_acudiente ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('parentesco_acudiente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="{{ route('estudiante.dashboard') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
