@extends('layouts.Administracion')

@section('title', 'Editar Asignatura')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Asignatura: {{ $asignatura->nombre_asignatura }}</h6>
            
            <form action="{{ route('admin.asignatura.update', $asignatura->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('Asignatura._form')
            </form>
        </div>
    </div>
</div>

@endsection
