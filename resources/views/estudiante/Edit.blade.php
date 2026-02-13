@extends('layouts.Administracion')

@section('title', 'Editar Estudiante')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Estudiante: {{ $estudiante->user->name ?? '' }}</h6>
            <form action="{{ route('admin.estudiante.update', $estudiante->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('Estudiante._form')
            </form>
        </div>
    </div>
</div>

@endsection
