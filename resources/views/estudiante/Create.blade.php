@extends('layouts.Administracion')

@section('title', 'Crear Estudiante')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Estudiante</h6>
            <form action="{{ route('admin.estudiante.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('Estudiante._form')
            </form>
        </div>
    </div>
</div>

@endsection
