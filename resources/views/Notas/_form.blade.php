<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Matrícula (Estudiante - Grado)</label>
        <select name="matriculado_id" class="form-select @error('matriculado_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($matriculados as $matricula)
                <option value="{{ $matricula->id }}" @selected(old('matriculado_id', $nota->matriculado_id ?? '') == $matricula->id)>
                    {{ $matricula->estudiante->user->name ?? 'Sin nombre' }} - {{ $matricula->grado->nombre_grado ?? 'Sin grado' }}
                </option>
            @endforeach
        </select>
        @error('matriculado_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Asignatura</label>
        <select name="asignatura_id" class="form-select @error('asignatura_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($asignaturas as $asignatura)
                <option value="{{ $asignatura->id }}" @selected(old('asignatura_id', $nota->asignatura_id ?? '') == $asignatura->id)>
                    {{ $asignatura->nombre_asignatura }} ({{ $asignatura->hilo->nombre_hilo ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('asignatura_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Periodo 1</label>
        <input type="number" step="0.1" min="0" max="5" name="nota1" 
               class="form-control @error('nota1') is-invalid @enderror" 
               value="{{ old('nota1', $nota->nota1 ?? '') }}">
        @error('nota1')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Periodo 2</label>
        <input type="number" step="0.1" min="0" max="5" name="nota2" 
               class="form-control @error('nota2') is-invalid @enderror" 
               value="{{ old('nota2', $nota->nota2 ?? '') }}">
        @error('nota2')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Periodo 3</label>
        <input type="number" step="0.1" min="0" max="5" name="nota3" 
               class="form-control @error('nota3') is-invalid @enderror" 
               value="{{ old('nota3', $nota->nota3 ?? '') }}">
        @error('nota3')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Periodo 4</label>
        <input type="number" step="0.1" min="0" max="5" name="nota4" 
               class="form-control @error('nota4') is-invalid @enderror" 
               value="{{ old('nota4', $nota->nota4 ?? '') }}">
        @error('nota4')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label text-info fw-bold">Nota Definitiva</label>
        <input type="number" step="0.01" name="nota_definitiva" id="nota_definitiva"
               class="form-control bg-dark text-white fw-bold @error('nota_definitiva') is-invalid @enderror" 
               value="{{ old('nota_definitiva', $nota->nota_definitiva ?? '') }}" readonly>
        @error('nota_definitiva')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-9 mb-3">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="2">{{ old('observaciones', $nota->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['nota1', 'nota2', 'nota3', 'nota4'];
    const inputs = fields.map(id => document.getElementsByName(id)[0]);
    const defInput = document.getElementById('nota_definitiva');

    function calculate() {
        let sum = 0;
        let count = 0;
        
        inputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) {
                sum += val;
                count++;
            }
        });

        if (count > 0) {
            const avg = sum / count;
            defInput.value = avg.toFixed(2);
            
            // Color feedback
            if (avg >= 3) {
                defInput.classList.remove('text-danger');
                defInput.classList.add('text-success');
            } else {
                defInput.classList.remove('text-success');
                defInput.classList.add('text-danger');
            }
        } else {
            defInput.value = '';
        }
    }

    inputs.forEach(input => {
        if (input) {
            input.addEventListener('input', calculate);
        }
    });

    // Initial calculation
    calculate();
});
</script>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.notas.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
