@extends('layouts.Administracion')

@section('title', 'Editar Curso')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Curso: {{ $curso->nombre_curso }}</h6>
            
            <form action="{{ route('admin.curso.update', $curso->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('Curso._form')
            </form>
        </div>
    </div>
</div>

@endsection
