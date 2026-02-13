@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Editar Matrícula</h6>
                <form action="{{ route('admin.matriculado.update', $matriculado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('Matriculado._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
