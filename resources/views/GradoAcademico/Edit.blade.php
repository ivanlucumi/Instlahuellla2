@extends('layouts.Administracion')

@section('title', 'Editar Grado Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Grado: {{ $gradoAcademico->nombre_grado_academico }}</h6>
            
            <form action="{{ route('admin.gradoacademico.update', $gradoAcademico->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('GradoAcademico._form')
            </form>
        </div>
    </div>
</div>

@endsection
