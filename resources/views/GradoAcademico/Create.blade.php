@extends('layouts.Administracion')

@section('title', 'Crear Grado Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Grado Académico</h6>
            
            <form action="{{ route('admin.gradoacademico.store') }}" method="POST">
                @csrf
                @include('GradoAcademico._form')
            </form>
        </div>
    </div>
</div>

@endsection
