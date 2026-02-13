<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estudiante</label>
        <select id="select_estudiante" class="form-select">
            <option value="">Seleccione para autocompletar...</option>
            @foreach($estudiantes as $est)
                <option value="{{ $est->numerodocumento_estudiante }}|{{ $est->user->name }}">
                    {{ $est->user->name }} ({{ $est->numerodocumento_estudiante }})
                </option>
            @endforeach
        </select>
        <small class="text-muted">Seleccione un estudiante para llenar documento y nombre.</small>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Documento Estudiante</label>
        <input type="text" name="documento_estudiante" id="documento_estudiante"
               class="form-control @error('documento_estudiante') is-invalid @enderror" 
               value="{{ old('documento_estudiante', $notasDefinitivas->documento_estudiante ?? '') }}" required>
        @error('documento_estudiante')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre Estudiante</label>
        <input type="text" name="nombre_estudiante" id="nombre_estudiante"
               class="form-control @error('nombre_estudiante') is-invalid @enderror" 
               value="{{ old('nombre_estudiante', $notasDefinitivas->nombre_estudiante ?? '') }}" required>
        @error('nombre_estudiante')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Grado Aprobado</label>
        <select name="grado_aprobado" class="form-select @error('grado_aprobado') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->nombre_grado }}" 
                    @selected(old('grado_aprobado', $notasDefinitivas->grado_aprobado ?? '') == $grado->nombre_grado)>
                    {{ $grado->nombre_grado }}
                </option>
            @endforeach
        </select>
        @error('grado_aprobado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Curso</label>
        <select name="curso" class="form-select @error('curso') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->nombre_curso }}" 
                    @selected(old('curso', $notasDefinitivas->curso ?? '') == $curso->nombre_curso)>
                    {{ $curso->nombre_curso }}
                </option>
            @endforeach
        </select>
        @error('curso')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Asignatura</label>
        <select name="nombre_asignatura" class="form-select @error('nombre_asignatura') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($asignaturas as $asignatura)
                <option value="{{ $asignatura->nombre_asignatura }}" 
                    @selected(old('nombre_asignatura', $notasDefinitivas->nombre_asignatura ?? '') == $asignatura->nombre_asignatura)>
                    {{ $asignatura->nombre_asignatura }}
                </option>
            @endforeach
        </select>
        @error('nombre_asignatura')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-2 mb-3">
        <label class="form-label">Nota Per. 1</label>
        <input type="number" step="0.01" min="0" max="5" name="nota_per1" id="nota_per1"
               class="form-control nota-calc @error('nota_per1') is-invalid @enderror" 
               value="{{ old('nota_per1', $notasDefinitivas->nota_per1 ?? '0') }}" required>
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label">Nota Per. 2</label>
        <input type="number" step="0.01" min="0" max="5" name="nota_per2" id="nota_per2"
               class="form-control nota-calc @error('nota_per2') is-invalid @enderror" 
               value="{{ old('nota_per2', $notasDefinitivas->nota_per2 ?? '0') }}" required>
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label">Nota Per. 3</label>
        <input type="number" step="0.01" min="0" max="5" name="nota_per3" id="nota_per3"
               class="form-control nota-calc @error('nota_per3') is-invalid @enderror" 
               value="{{ old('nota_per3', $notasDefinitivas->nota_per3 ?? '0') }}" required>
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label">Nota Per. 4</label>
        <input type="number" step="0.01" min="0" max="5" name="nota_per4" id="nota_per4"
               class="form-control nota-calc @error('nota_per4') is-invalid @enderror" 
               value="{{ old('nota_per4', $notasDefinitivas->nota_per4 ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Definitiva (Auto)</label>
        <input type="number" step="0.01" min="0" max="5" name="nota_definitiva" id="nota_definitiva"
               class="form-control bg-dark text-white @error('nota_definitiva') is-invalid @enderror" 
               value="{{ old('nota_definitiva', $notasDefinitivas->nota_definitiva ?? '0') }}" readonly>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.notas-definitivas.index') }}" class="btn btn-warning">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Autocompletar estudiante
        const selectEstudiante = document.getElementById('select_estudiante');
        const inputDoc = document.getElementById('documento_estudiante');
        const inputNom = document.getElementById('nombre_estudiante');

        // Como usamos Select2, debemos escuchar el evento de change de jQuery si select2 está activo,
        // o el nativo si no. El layout activa select2 para .form-select.
        $(selectEstudiante).on('change', function() {
            const val = $(this).val();
            if(val) {
                const parts = val.split('|');
                if(parts.length === 2) {
                    inputDoc.value = parts[0];
                    inputNom.value = parts[1];
                }
            }
        });

        // Calculo de definitiva
        const inputN1 = document.getElementById('nota_per1');
        const inputN2 = document.getElementById('nota_per2');
        const inputN3 = document.getElementById('nota_per3');
        const inputN4 = document.getElementById('nota_per4');
        const inputDef = document.getElementById('nota_definitiva');
        
        const inputsNotas = [inputN1, inputN2, inputN3, inputN4];

        function calcularDefinitiva() {
            const n1 = parseFloat(inputN1.value) || 0;
            const n2 = parseFloat(inputN2.value) || 0;
            const n3 = parseFloat(inputN3.value) || 0;
            const n4Val = inputN4.value; // string to check empty
            const n4 = parseFloat(n4Val) || 0;

            let prom = 0;
            
            // Si la nota 4 tiene valor (y asumimos > 0 o simplemente llenada), dividimos por 4
            // El usuario dijo "si se registra la cuarta nota". Si está vacía, no se registra.
            if (n4Val !== '' && !isNaN(parseFloat(n4Val)) && parseFloat(n4Val) > 0) {
                 prom = (n1 + n2 + n3 + n4) / 4;
            } else {
                 prom = (n1 + n2 + n3) / 3;
            }
            
            inputDef.value = prom.toFixed(2);
        }

        inputsNotas.forEach(input => {
            if(input) input.addEventListener('input', calcularDefinitiva);
        });
        
        // Calcular al inicio
        calcularDefinitiva();
    });
</script>
