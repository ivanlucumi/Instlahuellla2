@extends('layouts.Administracion')

@section('title', 'Crear Usuario')

@section('content')

<div class="row mb-3">
    <div class="col-12">
        <h4 class="text-white">Crear Nuevo Usuario</h4>
    </div>
</div>

<div class="bg-secondary rounded h-100 p-4">
    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @include('admin.usuarios._form')
    </form>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#roles').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Seleccione uno o más roles',
            allowClear: true
        });
    });
</script>
@endsection
